## Dissector Generator Backend

## How to Deploy

- Compile [https://github.com/qVipoL/dissector-generator](dissector-generator), run `make`.

- Move the compiled file from dissector-generator/out/bin to 
dissector-generator-backend/api/assets.

- Move the files a public directory on the server.

## Scheme

### Users

- int id PK AUTO_INCREMENT NOT NULL
- varchar(255) userName NOT NULL
- varchar(255) email UNIQUE NOT NULL
- varchar(255) password NOT NULL
- boolean isOwner DEFAULT 0 NOT NULL
- datetime createdAt CURRENT_TIMESTAMP NOT NULL

### Dissectors

- int id PK AUTO_INCREMENT NOT NULL
- varchar(255) name NOT NULL
- varchar(255) description
- varchar(255) code longtext NOT NULL
- int userId FK NOT NULL ON DELETE CASCADE
- datetime createdAt CURRENT_TIMESTAMP NOT NULL
- json fields 
