# Magyar települések REST API

## A projektről

Ez a projekt egy Laravel keretrendszerben készült REST API alkalmazás, amely magyar megyék és települések adatainak kezelésére szolgál.

Az API lehetőséget biztosít:
- Megyék listázására és kezelésére.
- Települések listázására és kezelésére.
- Települések név szerinti keresésére.
- Települések megye szerinti szűrésére.
- Tokenalapú hitelesítésre.

## Használt technológiák

- PHP
- Laravel
- MySQL
- Laravel Sanctum
- Bruno / Postman

## Telepítés és indítás

1. A projekt letöltése vagy klónozása.
2. Függőségek telepítése:

   ```bash
   composer install
   ```

3. A `.env.example` fájl másolása `.env` néven.
4. Az adatbázis-kapcsolat beállítása a `.env` fájlban.
5. Alkalmazáskulcs generálása:

   ```bash
   php artisan key:generate
   ```

6. Adatbázis-migrációk futtatása:

   ```bash
   php artisan migrate
   ```

7. A szerver elindítása:

   ```bash
   php artisan serve
   ```

Az API alapértelmezett címe:

`http://127.0.0.1:8000/api`

## Hitelesítés

A módosító műveletekhez Bearer token szükséges.

Bejelentkezés:

`POST /api/login`

Sikeres bejelentkezés után a válaszból kapott tokent a kérések Authorization fejlécében kell megadni:

`Authorization: Bearer TOKEN`

A GET végpontok nyilvánosan elérhetők.

## API végpontok

| Metódus | Végpont | Leírás | Hitelesítés |
|---|---|---|---|
| POST | `/api/login` | Bejelentkezés, token lekérése | Nem |
| GET | `/api/counties` | Megyék listázása | Nem |
| POST | `/api/counties` | Megye létrehozása | Igen |
| PUT | `/api/counties/{id}` | Megye módosítása | Igen |
| DELETE | `/api/counties/{id}` | Megye törlése | Igen |
| GET | `/api/cities` | Települések listázása | Nem |
| POST | `/api/cities` | Település létrehozása | Igen |
| PUT | `/api/cities/{id}` | Település módosítása | Igen |
| DELETE | `/api/cities/{id}` | Település törlése | Igen |

## Keresés és szűrés

Település keresése név alapján:

`GET /api/cities?search=Ráckeve`

Szűrés megyeazonosító alapján:

`GET /api/cities?county_id=1`

A két feltétel egyszerre is használható:

`GET /api/cities?search=Ráckeve&county_id=1`

## Példa JSON adatok

Megye létrehozása:

```json
{
    "name": "Pest"
}
```

Település létrehozása:

```json
{
    "name": "Ráckeve",
    "county_id": 1
}
```

## Tesztelés

Az API végpontjai Bruno vagy Postman alkalmazással tesztelhetők.

A projekt tesztelése során ellenőrizve lettek:
- Bejelentkezés és token lekérése.
- Megyék és települések listázása.
- Új megye és település létrehozása.
- Megye és település módosítása.
- Megye és település törlése.
- Települések keresése név alapján.
- Települések szűrése megyeazonosító alapján.
- Hitelesítés nélküli módosítás elutasítása.
