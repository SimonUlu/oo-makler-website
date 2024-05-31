# site.ext

## Installation instructions

1. run `composer install`
2. run `php please make:user`
3. run `npm i` && `npm run dev`


## Control Panel 

### Blueprints

#### Pages

##### 1. Simple Page 
Verkaufen: [Zum View](resources/views/pages/leistungen/verkaufen.antlers.html)

##### 2. Leistungen mit CTA 
Bewerten: [Zum View](resources/views/pages/leistungen/cta-page.antlers.html)


##### 3. Leistungen
Vermieten: [Zum View](resources/views/pages/leistungen/vermieten.antlers.html)
Finanzierung: [Zum View](resources/views/pages/leistungen/vermieten.antlers.html)

##### 4. Landing Page
Home: [Zum View](resources/views/pages/home.antlers.html)

##### 5. Unterseite Leistungen
Unterseite: [Zum View](resources/views/pages/leistungen/unterseiten/index.antlers.html)

##### 6. Simple Page
Kooperationen: [Zum View](resources/views/pages/unternehmen/kooperationspartner.antlers.html)

##### 7. Static Page
Impressum: nicht viel zu erfahren einfach den ganzen html code muss man in das cp schreiben
Datenschutz: nicht viel zu erfahren einfach den ganzen html code muss man in das cp schreiben

##### 8. Page
Kontakt: [Zum View](resources/views/pages/unternehmen/kontakt.antlers.html)
News: [Zum View](resources/views/pages/news/index.antlers.html)
Projekte: [Zum View](resources/views/neubauprojekte/index.antlers.html)
Referenzen: [Zum View](resources/views/pages/referenzobjekte/referenzen.antlers.html)
Team: [Zum View](resources/views/pages/team/index.antlers.html)
Karriere: [Zum View](resources/views/pages/team/karriere.antlers.html)

##### 9. Stadtbericht
Stadtteile: [Zum View](resources/views/pages/stadtteile/index.antlers.php)

#### News
##### 1. News
Stadtteile: [Zum View](resources/views/pages/news/show.antlers.html)

#### Projekte
##### 1. Neubauprojekte
Stadtteile: [Zum View](resources/views/neubauprojekte/show.antlers.html)

#### Immobilien
##### 1. Estatelist
Stadtteile: [Zum View](resources/views/estates/index.antlers.html)
##### 1. EstateShow
Stadtteile: [Zum View](resources/views/estates/show.antlers.html)


#### Estate Seo Landing Pages
##### 1. Estate Landing Page
Stadtteile: [Zum View](resources/views/pages/stadtteile/show.antlers.php)

#### Referenzen
##### 1. Referenzen
Stadtteile: Nur um auf anderen Seiten global angezeigt zu werden

#### Team
##### 1. Team
Nur um auf anderen Seiten im Grid die Team Member darzustellen

#### Vacancies
##### 1. Vacancies
Nur um auf anderen Seiten in Liste die freien Stellen anzuzeigen

### Globals 

##### 1. Browser Appearance
normal keine Änderungen nötig
##### 2. Business Information
Anpassen je nach Firma
##### 3. Business Hours
wenn nicht anders gesagt keine Anpassungen nötig
##### 4. Konfiguration
wenn nicht anders gesagt keine Anpassungen nötig
##### 5. Contact Forms
contact_type:
    - standard (kontakt über mail) **Email Inbox Formulare** und  **E-Mail Formulare Send From E-Mail** anpassen
    - on_office (jeder kontakt über on office) dann auch noch **e-mail_betreff_expose_mails** anpassen
on_office secrets: passende eingeben
##### 6. Contact Person
allgemeine Contact Person für dieses View das global verfügbar ist anpassen [Zum View](resources/views/partials/cta-sections/contact/cta-contact.antlers.html)
##### 7. Estate Map Configuration
selbsterklärend. Wenn Kunde Website mit Map bestellt dann hier Einstellungen anpassen
##### 8. Farben
auch selbsterklärend
##### 9. Footer Layout
alle Sachen vom Footer (gerade so eingestellt, dass ohne Ändeurngen entweder 1 oder 2 überkategorien reingepackt werden können)
##### 10. Google
normal keine Änderungen nötig, außer Kunde hat Google Einbindungen wie Analytics mit drin. und Einstellung ob Sterne im Immobilienfenster angezeigt werden
##### 11. Immobilien Darstellung
darstellung:
    - liste
    - kacheln x2
    - kacheln x3
pagination: yes/no
show_map: yes/no
ansprechpartner: yes/no
##### 12. Immobilien Filter kOnfig
normal keine Änderungen nötig
##### 13. Logo
normal keine Änderungen nötig
##### 14. Navigation Appearance
transparent: yes/no
##### 15. Review Konfig
nutze google oder immoscout oder indiv. Reviews
##### 16. SEO
weichtig allgemeine SEO EInstellungen für Graph Images und Sitemap
##### 17. Social Media
Intstagram usw. 
##### 18. Suchauftrag CTA
Box auf allen Seiten für den Suchauftrag textuelle Inhalte anpassbar für dieses View: [Zum View](resources/views/partials/cta-sections/suchauftrag/suchauftrag-cta.antlers.html)


## onOffice Api

### Listenansicht
Alle Logik eigentlich hier:
[Zur Livewire file](app/Http/Livewire/FilterComponent.php)
[Zum View](resources/views/estates/index.blade.php)

### Detailansicht
[Zur Logik](app/Http/Controllers/EstateController.php)
[Zum View](resources/views/estates/show.blade.php)


## Extra Modale

### Estate Map
Livewire = [Zur Livewire file](app/Http/Livewire/EstateMapComponent.php) 
View = [Zum View](resources/views/livewire/estate-map.blade.php)

### Ansprechpartner
Livewire = [Zur Livewire file](app/Http/Livewire/EstateUserComponent.php) 
View = [Zum View](resources/views/livewire/estate-user-component.blade.php)

### Stadtteile
Kartenansicht mit allen Stadtteilen = [Zum View](resources/views/pages/stadtteile/index.antlers.php)
Detailansicht mit einzelnen = [Zum View](resources/views/pages/stadtteile/show.antlers.php)

### Stadtteile
Kartenansicht mit allen Stadtteilen = [Zum View](resources/views/pages/stadtteile/index.antlers.php)
Detailansicht mit einzelnen = [Zum View](resources/views/pages/stadtteile/show.antlers.php)

### Google Reviews (extra Bezahlung) 
Controller = [Zum Controller ](app/Http/Controllers/GoogleReviewsController.php) 

### Blog mit Einrichtung und Schulung how to use statamic und kategorien
Livewire = [Zur Livewire file](app/Http/Livewire/NewsController.php) 
View = [Zum View](resources/views/livewire/news-controller.blade.php)


## Environment file contents

### Development

```env
Dump your .env values here with sensitive data removed.
```

### Production

```env
Dump your .env values here with sensitive data removed. The following is a production example that uses full static caching:
APP_NAME="Statamic Peak Template"
APP_ENV=production
APP_KEY="base64:TCNFyEUw6aSzYzHetET+bNi9PG/tBeRfDsTDK9Pgug4="
APP_DEBUG=false
APP_URL=

DEBUGBAR_ENABLED=false

LOG_CHANNEL=stack

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_DATABASE=
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.postmarkapp.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

IMAGE_MANIPULATION_DRIVER=imagick

STATAMIC_LICENSE_KEY=
STATAMIC_THEME=business

STATAMIC_API_ENABLED=false
STATAMIC_REVISIONS_ENABLED=false

STATAMIC_GIT_ENABLED=true
STATAMIC_GIT_PUSH=true
STATAMIC_GIT_DISPATCH_DELAY=5

STATAMIC_STATIC_CACHING_STRATEGY=full
SAVE_CACHED_IMAGES=false
STATAMIC_STACHE_WATCHER=false
STATAMIC_CACHE_TAGS_ENABLED=true

#STATAMIC_CUSTOM_CMS_NAME=
STATAMIC_CUSTOM_LOGO_OUTSIDE_URL="/visuals/client-logo.svg"
#STATAMIC_CUSTOM_LOGO_NAV_URL=
#STATAMIC_CUSTOM_FAVICON_URL=
#STATAMIC_CUSTOM_CSS_URL=
```

## NGINX config

Add the following to your NGINX config __inside the server block__ enable static resource caching:
```
expires $expires;
```

And this __outside the server block__:
```
map $sent_http_content_type $expires {
    default    off;
    text/css    max;
    ~image/    max;
    application/javascript    max;
    application/octet-stream    max;
}
```

## Deploy script Ploi

```bash
if [[ {COMMIT_MESSAGE} =~ "[BOT]" ]]; then
    echo "Automatically committed on production. Nothing to deploy."
    {DO_NOT_NOTIFY}
    # Uncomment the following line when using zero downtime deployments.
    # {CLEAR_NEW_RELEASE}
    exit 0
fi

cd {SITE_DIRECTORY}
git pull origin {BRANCH}
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build
{SITE_PHP} artisan cache:clear
{SITE_PHP} artisan config:cache
{SITE_PHP} artisan route:cache
{SITE_PHP} artisan statamic:stache:warm
{SITE_PHP} artisan queue:restart
{SITE_PHP} artisan statamic:search:update --all
{SITE_PHP} artisan statamic:static:clear
{SITE_PHP} artisan statamic:static:warm --queue

{RELOAD_PHP_FPM}

echo "🚀 Application deployed!"
```

## Deploy script Forge

```bash
if [[ $FORGE_DEPLOY_MESSAGE =~ "[BOT]" ]]; then
    echo "Automatically committed on production. Nothing to deploy."
    exit 0
fi

cd $FORGE_SITE_PATH
git pull origin $FORGE_SITE_BRANCH
$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build
$FORGE_PHP artisan cache:clear
$FORGE_PHP artisan config:cache
$FORGE_PHP artisan route:cache
$FORGE_PHP artisan statamic:stache:warm
$FORGE_PHP artisan queue:restart
$FORGE_PHP artisan statamic:search:update --all
$FORGE_PHP artisan statamic:static:clear
$FORGE_PHP artisan statamic:static:warm --queue

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock
```

## Placeholder
https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg
# site.ext

## Installation instructions

1. run `composer install`
2. run `php please make:user`
3. run `npm i` && `npm run dev`

## Environment file contents

### Development

```env
Dump your .env values here with sensitive data removed.
```

### Production

```env
Dump your .env values here with sensitive data removed. The following is a production example that uses full static caching:
APP_NAME="Statamic Peak Template"
APP_ENV=production
APP_KEY="base64:TCNFyEUw6aSzYzHetET+bNi9PG/tBeRfDsTDK9Pgug4="
APP_DEBUG=false
APP_URL=

DEBUGBAR_ENABLED=false

LOG_CHANNEL=stack

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_DATABASE=
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.postmarkapp.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"

IMAGE_MANIPULATION_DRIVER=imagick

STATAMIC_LICENSE_KEY=
STATAMIC_THEME=business

STATAMIC_API_ENABLED=false
STATAMIC_REVISIONS_ENABLED=false

STATAMIC_GIT_ENABLED=true
STATAMIC_GIT_PUSH=true
STATAMIC_GIT_DISPATCH_DELAY=5

STATAMIC_STATIC_CACHING_STRATEGY=full
SAVE_CACHED_IMAGES=false
STATAMIC_STACHE_WATCHER=false
STATAMIC_CACHE_TAGS_ENABLED=true

#STATAMIC_CUSTOM_CMS_NAME=
STATAMIC_CUSTOM_LOGO_OUTSIDE_URL="/visuals/client-logo.svg"
#STATAMIC_CUSTOM_LOGO_NAV_URL=
#STATAMIC_CUSTOM_FAVICON_URL=
#STATAMIC_CUSTOM_CSS_URL=
```

## NGINX config

Add the following to your NGINX config __inside the server block__ enable static resource caching:
```
expires $expires;
```

And this __outside the server block__:
```
map $sent_http_content_type $expires {
    default    off;
    text/css    max;
    ~image/    max;
    application/javascript    max;
    application/octet-stream    max;
}
```

## Deploy script Ploi

```bash
if [[ {COMMIT_MESSAGE} =~ "[BOT]" ]]; then
    echo "Automatically committed on production. Nothing to deploy."
    {DO_NOT_NOTIFY}
    # Uncomment the following line when using zero downtime deployments.
    # {CLEAR_NEW_RELEASE}
    exit 0
fi

cd {SITE_DIRECTORY}
git pull origin {BRANCH}
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build
{SITE_PHP} artisan cache:clear
{SITE_PHP} artisan config:cache
{SITE_PHP} artisan route:cache
{SITE_PHP} artisan statamic:stache:warm
{SITE_PHP} artisan queue:restart
{SITE_PHP} artisan statamic:search:update --all
{SITE_PHP} artisan statamic:static:clear
{SITE_PHP} artisan statamic:static:warm --queue

{RELOAD_PHP_FPM}

echo "🚀 Application deployed!"
```

## Deploy script Forge

```bash
if [[ $FORGE_DEPLOY_MESSAGE =~ "[BOT]" ]]; then
    echo "Automatically committed on production. Nothing to deploy."
    exit 0
fi

cd $FORGE_SITE_PATH
git pull origin $FORGE_SITE_BRANCH
$FORGE_COMPOSER install --no-interaction --prefer-dist --optimize-autoloader --no-dev

npm ci
npm run build
$FORGE_PHP artisan cache:clear
$FORGE_PHP artisan config:cache
$FORGE_PHP artisan route:cache
$FORGE_PHP artisan statamic:stache:warm
$FORGE_PHP artisan queue:restart
$FORGE_PHP artisan statamic:search:update --all
$FORGE_PHP artisan statamic:static:clear
$FORGE_PHP artisan statamic:static:warm --queue

( flock -w 10 9 || exit 1
    echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock
```

## Placeholder
https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg

### onOffice File Sizes
@175x114
@800x600
@600x400
@500x250
@400x200
auch: 
@x200 etc.


## Template

On the other repositories you have to add this template repository as a remote.

git remote add template [URL of the template repo]
Then run git fetch to update the changes

git fetch --all
Then is possible to merge another branch from the new remote to your current one.

git merge template/[branch to merge] --allow-unrelated-histories
z.B. git merge template/main --allow-unrelated-histories


### onOffice File Sizes
@175x114
@800x600
@600x400
@500x250
@400x200
auch: 
@x200 etc.


## Template

On the other repositories you have to add this template repository as a remote.

git remote add template [URL of the template repo]
Then run git fetch to update the changes

git fetch --all
Then is possible to merge another branch from the new remote to your current one.

git merge template/[branch to merge] --allow-unrelated-histories
z.B. git merge template/main --allow-unrelated-histories


docker compose exec -it laravel_fpm sh

## phpstan 
execute 
./vendor/bin/phpstan analyse --memory-limit=2G
