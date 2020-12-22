<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Yaml\Yaml;

class FetchCommand extends Command
{
    protected static $defaultName = 'app:fetch';


    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var
     */
    protected $projectDir;

    public function __construct(HttpClientInterface $client, $projectDir)
    {
        $this->projectDir = $projectDir;
        $this->client = $client;
        $this->loadEnv();
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Fetches a WeBuild JSON file')
            ->setHelp('This command allows you to fetch a WeBuild JSON file');

        $this
            ->addArgument('uuid', InputArgument::REQUIRED, 'The content id')
            ->addArgument('entity_bundle', InputArgument::OPTIONAL, 'The content entity bundle.', "editorial_page")
            ->addArgument('type', InputArgument::OPTIONAL, 'The content type', "single_page_content")
            ->addArgument('first_level', InputArgument::OPTIONAL, 'The parsing specs for first level elements', $this->getFirstLevelYml())
            ->addArgument('mapping', InputArgument::OPTIONAL, 'The parsing specs for whole mapping', $this->getMappingYml())
            ->addArgument('baseurl', InputArgument::OPTIONAL, 'The Base URL', $this->getBaseUrl())
            ->addArgument('api_endpoint', InputArgument::OPTIONAL, 'The API endpoint', $this->getApiEndpoint());

    }

    /**
     * Executes the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '=======================',
            'WeBuild Content Fetcher',
            '=======================',
            '',
        ]);

        $uuid = $input->getArgument('uuid');
        $bundle = $input->getArgument('entity_bundle');
        $type = $input->getArgument('type');
        $baseurl = $input->getArgument('baseurl');
        $apiendpoint = $input->getArgument('api_endpoint');

        $value = Yaml::parse(
            file_get_contents($input->getArgument('first_level')) . "\n" .
            file_get_contents($input->getArgument('mapping'))
        );

        $this->first_level_node_types =
            isset($value['first_level_node_types']) && !empty($value['first_level_node_types']) ?
                $value['first_level_node_types'] : [];

        $this->parsings =
            isset($value['mapping']) && !empty($value['mapping']) ?
                $value['mapping'] : [];

        $urltofetch = sprintf("%s/%s/%s/%s/%s", $baseurl, $apiendpoint, $type, $bundle, $uuid);

        $output->writeln([
            '=======================',
            'Fetching',
            '=======================',
            '',
            "UUID:           <info>{$uuid}</info>",
            "Type:           <info>{$bundle}</info>",
            "Entity Bundle:  <info>{$type}</info>",
            "Url to fetch:   <info>{$urltofetch}</info>",
            '',
            '=======================',
        ]);


        $response = $this->client->request(
            'GET',
            $urltofetch
        );

        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->toArray();

        $output->writeln([
            '=======================',
            'Fetched',
            '=======================',
            '',
            "Status Code:           <info>{$statusCode}</info>",
            "Content Type:          <info>{$contentType}</info>",
            '',
        ]);

        $included = $content['included'];

        $nodes = $relations = [];

        foreach ($included as $node) {
            $node_uuid = $node['id'];
            if ($this->isFirstLevel($node)) {
                $nodes[$node_uuid] = $node;
            } else {
                $relations[$node_uuid] = $node;
            }
        }

        $output->writeln([
            '=======================',
        ]);

        foreach ($nodes as $node_uuid => $node) {
            $node_type = $node['type'];
            $node_content = $this->parseNode($node, $relations);

            $output->writeln([
                "Type:          <info>{$node_type}</info>",
                "UUID:          <info>{$node_uuid}</info>",
                '------------------------',
            ]);

            foreach ($node_content as $k => $v) {
                $output->writeln([
                    "<comment>{$k}</comment>",
                ]);
                if (is_array($v)) {
                    foreach ($v as $kk => $vv) {
                        if (is_array($vv)) {
                            $output->writeln([
                                "-",
                            ]);
                            foreach ($vv as $kkk => $vvv) {
                                $output->writeln([
                                    "    <comment>{$kkk}</comment> <info>{$vvv}</info>",
                                ]);
                            }
                        } else {
                            $output->writeln([
                                "    <comment>{$kk}</comment>",
                                "        <info>{$vv}</info>",
                            ]);
                        }
                    }
                } else {
                    $output->writeln([
                        "    <info>{$v}</info>",
                    ]);
                }
            }
            $output->writeln([
                '=======================',
            ]);

        }


        return Command::SUCCESS;
    }

    protected $first_level_node_types = [];

    protected function isFirstLevel($node)
    {
        $node_type = isset($node['type']) ? $node['type'] : "";
        return in_array($node_type, $this->first_level_node_types);
    }


    protected $parsings = [];

    protected static $yaml_delimiter = ">";

    protected static $yaml_rel_delimiter = ">>";

    protected function getParsingSpec($node_type)
    {
        return isset($this->parsings[$node_type]) && !empty($this->parsings[$node_type]) ? $this->parsings[$node_type] : [];
    }

    protected function parseNode($node, $relations)
    {
        $node_type = $node['type'];
        $found = false;
        $content = [];

        $parsing_specs = $this->getParsingSpec($node_type);
        if (!empty($parsing_specs)) {
            $content = [];
            if (isset($parsing_specs['direct']) && !empty($parsing_specs['direct'])) {
                $node_attr = $node['attributes'];
                $direct = $parsing_specs['direct'];
                foreach ($direct as $k => $p) {
                    $path = explode(self::$yaml_delimiter, $p);
                    $res = $node_attr;
                    $found = !empty($res);
                    foreach ($path as $_p) {
                        $_p = trim($_p);
                        if (isset($res[$_p])) {
                            $res = $res[$_p];
                        } else {
                            $found = false;
                        }
                    }
                    if ($found) {
                        $content[$k] = $res;
                    }
                }
            }

            if (isset($parsing_specs['relationship']) && !empty($parsing_specs['relationship'])) {
                $node_rels = $node['relationships'];
                $relationships = $parsing_specs['relationship'];
                $cnt = 1;
                foreach ($relationships as $k => $p) {
                    $rel_path = explode(self::$yaml_rel_delimiter, $p);
                    $rel_deep = count($rel_path);
                    $res = $node_rels;

                    foreach ($rel_path as $_rp) {
                        $_rp = trim($_rp);
                        $path = explode(self::$yaml_delimiter, $_rp);
                        $found = !empty($res);

                        foreach ($path as $_p) {
                            $_p = trim($_p);
                            if (isset($res[$_p])) {
                                $res = $res[$_p];
                            } else {
                                $found = false;
                            }
                        }
                        if ($found) {
                            if ($cnt != $rel_deep) {
                                if ($cnt + 1 == $rel_deep) {

                                    if (is_array($res)) {
                                        $content[$k] = [];
                                        foreach ($res as $_res) {
                                            $content[$k][] = $this->parseNode($relations[$_res['id']], $relations);
                                        }
                                    } else {
                                        if (isset($relations[$res]) && !empty($relations[$res])) {
                                            $content[$k] = $this->parseNode($relations[$res], $relations);
                                            break;
                                        }
                                    }
                                } else {
                                    $res =
                                        isset($relations[$res]) && !empty($relations[$res]) &&
                                        isset($relations[$res]['relationships']) && !empty($relations[$res]['relationships']) ?
                                            $relations[$res]['relationships'] :
                                            [];
                                }

                            }
                        }
                        $cnt++;
                    }
                }
            }

        }
        return $content;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////  ENVIRONMENT  /////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @var Dotenv
     */
    protected $dotenv;

    /**
     * Loads the .env file
     */
    protected function loadEnv()
    {
        $this->dotenv = new Dotenv();
        $this->dotenv->loadEnv($this->projectDir . '/.env');
    }

    ////////////////////////////////////////  Env parameters loading  ///////////////////////////////////////////////////

    /**
     * The API base URL to call
     *
     * @var string
     */
    protected $baseurl;

    /**
     * Retrieves the API base URL to call from the .env file
     *
     * @return mixed|string
     */
    protected function getBaseUrl()
    {
        if (!isset($this->baseurl)) {
            $this->baseurl = $_ENV['BASE_URL'];
        }
        return $this->baseurl;
    }

    /**
     * The API endpoint
     *
     * @var string
     */
    protected $apienpoint;

    /**
     * Retrieves the API endpoint from the .env file
     *
     * @return mixed|string
     */
    protected function getApiEndpoint()
    {
        if (!isset($this->apienpoint)) {
            $this->apienpoint = $_ENV['API_ENDPOINT'];
        }
        return $this->apienpoint;
    }

    /**
     * The modules mapping file
     *
     * @var string
     */
    protected $mappingyml;

    /**
     * Retrieves the modules mapping file from the .env file
     *
     * @return mixed|string
     */
    protected function getMappingYml()
    {
        if (!isset($this->mappingyml)) {
            $this->mappingyml = $_ENV['MAPPING'];
        }
        return $this->mappingyml;
    }

    /**
     * The first level modules specs file
     *
     * @var string
     */
    protected $firstlevelyml;

    /**
     * Retrieves the first level modules specs file from the .env file
     *
     * @return mixed|string
     */
    protected function getFirstLevelYml()
    {
        if (!isset($this->firstlevelyml)) {
            $this->firstlevelyml = $_ENV['FIRST_LEVEL'];
        }
        return $this->firstlevelyml;
    }


}