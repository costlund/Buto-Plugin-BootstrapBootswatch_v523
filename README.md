# Buto-Plugin-BootstrapBootswatch_v523

Add theme from Bootswatch to your Buto project.

## Theme settings

Set param data/theme to one of www.bootswatch.com themes for version 5.2.3.

```
type: widget
data:
  plugin: bootstrap/bootswatch_v523
  method: include
  data:
    theme: Lux
```


```
- Cerulean
- Cosmo
- Cyborg
- Darkly
- Flatly
- Journal
- Litera
- Lumen
- Lux
- Materia
- Minty
- Morph
- Pulse
- Quartz
- Sandstone
- Simplex
- Sketchy
- Slate
- Solar
- Spacelab
- Superhero
- United
- Vapor
- Yeti
- Zephyr
```

## Select theme by user

Add an selectbox to let user change theme. Good for test purpose.

```
type: widget
data:
  plugin: bootstrap/bootswatch_v523
  method: selectbox
```

## Extra css

### Cerulean

H-tags color.

