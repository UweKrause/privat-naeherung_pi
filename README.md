# Näherungsweise statistische Bestimmung von Pi

## Allgemeiner Ablauf
1. Auf den Boden wird ein Quadrat gezeichnet
1. In dieses Quadrat wird ein Kreis mit gleichem Durchmesser wie die Seitenlänge des Quadrats gezeichnet (Inkreis)
1. Das Quadrat wird in vier Quadranten geteilt, es entstehen:
   1. ein Viertelquadrat
   1. ein Viertelkreis
1. Regentropfen fallen zufällig verteilt auf die Szene
1. Betrachtet wird einer dieser Quadranten

Pi ist das Verhältnis der Regentropfen eines der Viertelkreise zu den Regentropfen außerhalb des Viertelkreises,
aber innerhalb des Quadranten

### Siehe auch:
https://de.wikipedia.org/wiki/Kreiszahl#Statistische_Bestimmung

# Ergebnis
## Beispiel
![Bild](/docs/screenshot.jpg)

```
Tropfen gesamt: 5000
Grün: 958 / Rot: 305 = 3.1409836065574 (Näherungswert dieses Simulationsdurchgangs)
pi = 3.1415926535898 (laut php)
Ausführungszeit: 0.0229568 Sekunden.
```
