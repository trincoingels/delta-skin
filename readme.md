# README #

WME: TODO...

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* Quick summary
* Version
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up
* Configuration
* Dependencies
* Database configuration
* How to run tests
* Deployment instructions

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact


==================================================
23-06-2014 WME
After checkout, navigate to search/ dir and run from CLI: 'php composer.phar install'.

This will cause composer to download all necessary dependencies in search/vendor/ dir (this will also generate the composer.lock file). 

The vendor dir should not be committed (put in svn ignore)

27-02-2015 WME COMPOSER ERROR
Fatal error: Class 'Symfony\Component\Yaml\Yaml' not found in /home/hzadmin/wikisgit/skins/deltaskin/search/search_settings.php on line 16

Mediawiki core kan composer gebruiken (dat is bijvoorbeeld het geval voor de skin Chameleon op de testserver, zie /home/hzadmin/wikisgit/testbase/core/composer.json en de bijbehorende vendor dir). Dit zal naar de (nabije) toekomst steeds vaker zo zijn, ivm nieuwere versies.

De deltaskinzoekmachine gebruikt ook composer (zie op testserver /home/hzadmin/wikisgit/skins/deltaskin/search/composer.json met bijbehorende vendor dir), voor de phpclient van elasticsearch en voor het opstellen van parameters.yml.

Deze twee conflicteren met elkaar en kunnen niet samen.

De tijdelijke oplossing is dus zo simpel als volgt (composer biedt hier denk ik een oplossing voor maar die kon ik nog niet vinden):

if ( mediawiki-core uses composer ) then
     add the specific "deltaskin search composer.json dependencies" to the "mediawiki-core composer.json".
else
    just use the specific "deltaskin search composer.json" at that location.

Een mooie structurele oplossing voor later is om de deltaskin (met de search functionaliteit) beschikbaar te stellen via composer (git en packagist.org). Zodat deze op eenzelfde manier als chameleonskin. Hiervoor wordt een jira ticket gemaakt. Dit zal nog wel uitgezocht moeten worden.