# Architecture

1. Models are little more than entities
   -  Models hold scopes
   -  Models hold collections
2. Repositories work with input/output of data
3. Services work with repositories and hold logic
4. Controllers coordinate
   -  We use Laravel Requests to validate data, validation does not happen in controllers directly
   -  controllers use can `try` services and `catch` errors this allows controllers to direct what needs to load

## Domain

The bulk of the app is stored in the `Domain` folder. Everything is grouped:

```
- Domain
    - Events
        - Event.php
        - EventRepository.php
        - EventService.php
        - EventCollection.php
```
