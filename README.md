De website Vacit is een site waarop sollicitanten kunnen zoeken naar interessante vacatures en waarop bedrijven interessante kandidaten voor de door hen geplaatste vacatures kunnen vinden.

In de eerste week van het project heb ik ERD's en ASD's gemaakt om de data structuur inzichtelijk te krijgen. Daarnaast heb ik met php de functies gemaakt en getest die met de database communiceren in de backend kant. Tijdens de tweede week heb ik de meeste functionaliteiten van de website gekoppeld aan de backend kant. In de laatste week heb ik de website verder verfraaid en de inlog- en uploadfunctionaliteiten verbeterd. Hierbij is gebruik gemaakt van diverse tools, zoals vegas voor javascript, die een dynamische slideshow mogelijk maakt.

## Structuur

---

De site heeft diverse pagina's, te weten:

* Homepage
* Detailpagina
* Profielpagina (Voor sollicitant en werkgever)
* Mijn Sollicitaties (Alleen voor sollicitant)
* Mijn Vacatures (Alleen voor werkgever)
* Mijn Vacatures_Sollicitaties (Alleen voor werkgever)
* Inloggen
* Registreren
* Vacatures Toevoegen (Alleen voor werkgever)

---
---

## Technologieën

---

* MySQL Database
* PHP
* HTML
* CSS
* Foundation
* FontAwesome
* JQuery
* JavaScript
* Vegas
* Datatables
* Symfony
* Design pattern Model View Controller

Met behulp van het Symfony framework in PHP is de communicatie van de backend code met de achterliggende database veel gemakkelijker geworden. Tevens is het design pattern Model View Controller geïmplementeerd, waardoor de code is onderverdeeld in controllers, services, repositories en entities. Ook is er een command klasse gemaakt waardoor werkgevers hun informatie vanuit een spreadsheet kunnen importeren.

## Methoden en Technieken

Het ERD, met alle PK's en FK's, van deze case ziet er als volgt uit:

![ERD](public/screenshots/vacit_ERD.png)




