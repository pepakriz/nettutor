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
