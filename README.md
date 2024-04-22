## Setup
### nginx docker
1. Hozz létre egy `.env` fájlt.
   1. Hozzd létre a `PORT_WEB` változót, ez lesz a szerver portja.
   2. Opcionálisan hozzd létre az `UID` és `GID` változót.
2. Futtasd a szervert: `docker compose up`

### tailwind
A `start-tailwind.bash` a tailwind elindításához kell. A `www` mappában a dockerben `fish start-tailwind.bash`-t futtasd. Ez létrehoz egy `style-tailwind.css` fájlt. A fájl automatikusan frissül, a `.gitignore`-ban benne van, hiszen ez egy generált fájl.