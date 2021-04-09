README.md
# Data Object

Data objects are immutable objects which hold validated data that are required for successfully executing entity operations such as create, update and so on.

## Setup

You need to register value resolver and nomrmalizers in `services.yaml`

### Registering value resolver
```yaml
    StartupJobsCom\Shared\DataObject\DataObjectResolver:
        tags: ['controller.argument_value_resolver']
```

### Registering normalizers
```yaml
    StartupJobsCom\Shared\DataObject\Normalizer\DataObjectNormalizer:
        tags: ['serializer.normalizer']

    StartupJobsCom\Shared\DataObject\Normalizer\PayloadEntityNormalizer:
        tags: ['serializer.normalizer']
```

You may also add another normalizer when needed
