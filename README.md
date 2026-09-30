# Klientu pārvaldība (PHP + MySQL)

Vienkārša tīmekļa aplikācija klientu reģistrēšanai un apskatei. Lietotājs caur formu ievada klienta datus, tie tiek saglabāti MySQL/MariaDB datubāzē un attēloti tabulā.

## Funkcionalitāte

- Klienta reģistrācijas forma: vārds, uzvārds, e-pasts, telefons
- Datu saglabāšana datubāzē
- Visu klientu saraksts tabulas veidā

## Tehnoloģijas

- PHP 8.5.11
- MySQL / MariaDB
- PDO (`pdo_mysql` paplašinājums)

## Projekta struktūra

| Fails | Uzdevums |
|---|---|
| `db.php` | Savienojums ar datubāzi, datubāzes un tabulas izveide |
| `header.php` | Kopīgs HTML sākums un navigācija |
| `index.php` | Reģistrācijas forma un tās apstrāde |
| `klienti.php` | Klientu saraksta attēlošana |

## Datubāzes struktūra

Tabula `clients` datubāzē `klienti`:

| Kolonna | Tips | Piezīmes |
|---|---|---|
| `id` | INT | AUTO_INCREMENT, PRIMARY KEY |
| `name` | VARCHAR(100) | NOT NULL |
| `surname` | VARCHAR(100) | NOT NULL |
| `email` | VARCHAR(100) | NOT NULL, UNIQUE |
| `phone` | VARCHAR(20) | NOT NULL |

Datubāze un tabula tiek izveidoti automātiski, pirmo reizi atverot jebkuru lapu (`CREATE ... IF NOT EXISTS`).
