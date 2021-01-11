# Pages

Here are the current pages

| Page | Link | ID |
| ---- | ---- | -- |
| HOMEPAGE | [/it/homepage-app-test](https://www.webuildgroup.com/it/homepage-app-test) | 96eea71d-50ac-429a-848a-a47851c2eeb8 |
| GRUPPO  | [/it/il-gruppo](http://testapp.salini-impregilo.doing.com/it/il-gruppo) | 45781018-f9d5-49c6-b8f3-8d3f1f491a11 |
| AREA DI BUSINESS / SUSTAINABLE MOBILITY  | [/it/progetti/sustainable-mobility](http://testapp.salini-impregilo.doing.com/it/progetti/sustainable-mobility) | 0e9476dd-9b99-4489-b120-7e67f2a12f74 |
| SOSTENIBILITA’  | [/it/sostenibilita](http://testapp.salini-impregilo.doing.com/it/sostenibilita) | b2d1ff2a-a44d-456b-a5ba-b57e8c050663 |
| INVESTITORI  | [/it/investitori](http://testapp.salini-impregilo.doing.com/it/investitori) | 9ee765ce-2619-4c61-8f2d-8cdccc4d7ee4 |
| STRATEGIA | [/it/investitori/strategia](http://testapp.salini-impregilo.doing.com/it/investitori/strategia) | a838fad4-8d5e-476b-b1b1-64facac576ed |
| RISULTATI FINANZIARI  | [/it/investitori/risultati-finanziari](http://testapp.salini-impregilo.doing.com/it/investitori/risultati-finanziari) | 10ccf123-d9f0-4c19-a225-365a44e8a5ae |
| COMUNICATI STAMPA  | [/it/media/comunicati-stampa](http://testapp.salini-impregilo.doing.com/it/media/comunicati-stampa) | f3e954fb-1c1b-4866-b972-11028511eb15 |
| EVENTI  | [/it/investitori/calendario](http://testapp.salini-impregilo.doing.com/it/investitori/calendario) | 57dd64d4-8869-4c68-ae41-b8f880f090b5 |
| PODCAST  | [/it/podcast-webuild-app](https://www.webuildgroup.com/it/podcast-webuild-app) | ad502821-87e7-4734-8ded-154647d3443e |

## Homepage

|   |   |
| - | - |
| Status | **Mapped** except for the _view_ module |
| URI | https://www.webuildgroup.com/it/homepage-app-test |
| Base URL | https://corporatebe.webuildgroup.com |
| ID | 96eea71d-50ac-429a-848a-a47851c2eeb8 |

```
php bin/console app:fetch 96eea71d-50ac-429a-848a-a47851c2eeb8 https://corporatebe.webuildgroup.com
```

### Note
- Occorre hardcodare l'immagine di Canvas
- Occorre hardcodare le immagini per "_Il mondo Webuild_" (evidenziato da WB) 
- Manca in API la sezione "_Il mondo Webuild_"
- Mancano in API le immagini per le news
- La sezione eventi è realizzata tramite modulo `node--view_module`

## Gruppo

|   |   |
| - | - |
| Status | **Mapped** |
| URI | http://testapp.salini-impregilo.doing.com/it/il-gruppo |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | 45781018-f9d5-49c6-b8f3-8d3f1f491a11 |

```
php bin/console app:fetch 45781018-f9d5-49c6-b8f3-8d3f1f491a11 http://corporatebe-qa.salini-impregilo.doing.com
```

### Note
- WB dice che va hardcodata immagine di canvas ma in realtà può essere restituita tramite API nel modulo `node--section_home_page_title_module`
- Sono presenti due moduli `node--infographic_module` che dovrebbero venir visualizzati in maniera distinta in APP, preceduti dal titoletto "Track record", non restituito dalle API e con 7 immagini, non restituite dalla app
  - Si potrebbe pensare di hardcodare il titoletto e gestire le due visualizzazioni in maniera differente a seconda dell'ordine di restituzione dei due moduli, il primo in un modo, il secondo nell'altro
  - Occorre hardcodare le 7 immagini (evidenziato anche da WB)  
- Manca in API l'immagine per "_Sostenibilità_"
- Manca in API l'immagine per "_Risultati finanziari_"

## Sustainable mobility

|   |   |
| - | - |
| Status | **Mapped** |
| URI | http://testapp.salini-impregilo.doing.com/it/progetti/sustainable-mobility |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | 0e9476dd-9b99-4489-b120-7e67f2a12f74 |

```
php bin/console app:fetch 0e9476dd-9b99-4489-b120-7e67f2a12f74 http://corporatebe-qa.salini-impregilo.doing.com
```

## Sostenibilità

|   |   |
| - | - |
| Status | **Mapped** |
| URI | http://testapp.salini-impregilo.doing.com/it/sostenibilita |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | b2d1ff2a-a44d-456b-a5ba-b57e8c050663 |

```
php bin/console app:fetch b2d1ff2a-a44d-456b-a5ba-b57e8c050663 http://corporatebe-qa.salini-impregilo.doing.com
```

## Investitori

|   |   |
| - | - |
| Status | **Mapped** except for the _view_ module |
| URI | http://testapp.salini-impregilo.doing.com/it/investitori |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | 9ee765ce-2619-4c61-8f2d-8cdccc4d7ee4 |

```
php bin/console app:fetch 9ee765ce-2619-4c61-8f2d-8cdccc4d7ee4 http://corporatebe-qa.salini-impregilo.doing.com
```

## Strategia

|   |   |
| - | - |
| Status | **Mapped** |
| URI | http://testapp.salini-impregilo.doing.com/it/investitori/strategia |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | a838fad4-8d5e-476b-b1b1-64facac576ed |

```
php bin/console app:fetch a838fad4-8d5e-476b-b1b1-64facac576ed http://corporatebe-qa.salini-impregilo.doing.com
```

## Risultati finanziari

|   |   |
| - | - |
| Status | **Mapped** |
| URI | http://testapp.salini-impregilo.doing.com/it/investitori/risultati-finanziari |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | 10ccf123-d9f0-4c19-a225-365a44e8a5ae |

```
php bin/console app:fetch 10ccf123-d9f0-4c19-a225-365a44e8a5ae http://corporatebe-qa.salini-impregilo.doing.com
```

## Comunicati stampa

|   |   |
| - | - |
| Status | **Mapped** except for the _view_ module |
| URI | http://testapp.salini-impregilo.doing.com/it/media/comunicati-stampa |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | f3e954fb-1c1b-4866-b972-11028511eb15 |

```
php bin/console app:fetch f3e954fb-1c1b-4866-b972-11028511eb15 http://corporatebe-qa.salini-impregilo.doing.com
```

## Eventi

|   |   |
| - | - |
| Status | **Mapped** except for the _view_ module |
| URI | http://testapp.salini-impregilo.doing.com/it/investitori/calendario |
| Base URL | http://corporatebe-qa.salini-impregilo.doing.com |
| ID | 57dd64d4-8869-4c68-ae41-b8f880f090b5 |

```
php bin/console app:fetch 57dd64d4-8869-4c68-ae41-b8f880f090b5 http://corporatebe-qa.salini-impregilo.doing.com
```

## Podcast

|   |   |
| - | - |
| Status | **Mapped** |
| URI | https://www.webuildgroup.com/it/podcast-webuild-app |
| Base URL | https://corporatebe.webuildgroup.com |
| ID | ad502821-87e7-4734-8ded-154647d3443e |

```
php bin/console app:fetch ad502821-87e7-4734-8ded-154647d3443e https://corporatebe.webuildgroup.com
```

