Nettutor
========

Testovací sandbox pro workshop určený Poslední Sobotě


Installing
----------

```bash
git clone git@github.com:pepakriz/nettutor.git
cd nettutor
composer install
```

Ověřte funkčnost v prohlížeči.


I. Vytvoření stránky pro kontakty
---------------------------------

Zadání: Vytvořte stránku pro kontakty na URL `/contact`. Stránka musí obsahovat správný nadpis a odkaz na homepage.

Ověření:

```bash
vendor/bin/tester tests/App/ContactPresenterTest.phpt
```


II. Komponenta pro navigaci
---------------------------

Zadání: Vytvořte komponentu, která bude vypisovat strukturu webu s odkazy. Komponentu zaregistrujte do presenteru pod jménem `navigation`. Důležité je, aby se navigace zobrazovala jak na homepage, tak i na stránce kontaktů. Využijte HTML tagy ul, li, a.

Ověření:

```bash
vendor/bin/tester tests/App/NavigationControlTest.phpt
```
