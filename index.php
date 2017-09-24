<!DOCTYPE html>
<html>
    <!-- Naeherungsweise statistische Bestimmung von Pi -->
    <!-- https://de.wikipedia.org/wiki/Kreiszahl#Statistische_Bestimmung -->
    
    <!-- (Monte-Carlo-Algorithmus - liefert Werte, die in der Naehe von Pi liegen) -->
    <head>
        <title>Naeherungssimulation Pi</title>
    </head>
    
    <body>
<?php

/**
 * Zeitmessung
 */
$script_start = microtime(true);

/**
 * Settings
 */
//Maximal erlaubte Anzahl Tropfen
$SET_tropfen_maximal = 1000000;

//Anzahl der Tropfen (default)
$SET_tropfen = 10000;

//Schwellwert, ab wann die Tropfen in den nicht betrachteten Quadranten ausgeblendet werden
$SET_tropfen_ausblenden = 10000;

/**
 * eventuelle Fehlermeldungen sammeln
 */
$FEHLER = array();

//Benutzereingabe Anzahl Tropfen
if (isset($_GET["tropfen"])) {
                if (is_numeric($_GET["tropfen"])) {
                                if ($_GET["tropfen"] > 0 && $_GET["tropfen"] <= $SET_tropfen_maximal) {
                                                $SET_tropfen = $_GET["tropfen"];
                                } else {
                                                $FEHLER[] = "Erlaubter Wert ( 0 < X < $SET_tropfen_maximal ). Setze auf default: $SET_tropfen Tropfen.";
                                }
                } else {
                                $FEHLER[] = "Erlaubter Wert muss numerisch sein und ( 0 < X < $SET_tropfen_maximal ). Setze auf default: $SET_tropfen Tropfen.";
                }
}

?>
      <form action="/" method="get">
            <fieldset>
                <legend>Ergebnis</legend>
                
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" baseProfile="full" width="200px" height="200px" fill="none">
                
                    <!-- Der Kreis-->
                    <circle cx="100" cy="100" r="100" stroke="black" stroke-width="2px" />
                    
                    <!-- Rechteckunterteilung -->
                    <rect x="0" y="0" width="100" height="100" fill="none" stroke="brown" stroke-width="1px" />
                    <rect x="100" y="0" width="100" height="100" fill="none" stroke="blue" stroke-width="1px" />
                    <rect x="0" y="100" width="100" height="100" fill="none" stroke="green" stroke-width="1px" />
                    <rect x="100" y="100" width="100" height="100" fill="none" stroke="red" stroke-width="1px" />
                    
                    <!-- Die Regentropfen -->    
                    <?php

/**
 * Erstelle Koordinaten fuer Viertelkreis
 */

$arx = array();
$ary = array();

for ($w = 0; $w <= 720; $w++) {
                
                $x = round(cos(90 - $w) * 100);
                $y = round(sin(90 - $w) * 100);
                
                // Quadrat Unten Rechts
                if ($x >= 0 && $x <= 100 && $y >= 0 && $y <= 100) {
                                $arx[] = $x;
                                $ary[] = $y;
                }
}

/**
 * Let it rain
 */

// Zaehler
$blue = $green = $red = 0;

$color_default = "blue";

//generiere Tropfen
for ($i = 0; $i <= $SET_tropfen; $i++) {
                
                $x = rand(-100, 100);
                $y = rand(-100, 100);
                
                $show_tropfen = true;
                //hier kann man Tropfen ausserhalb des Zielquadrates ausblenden (schnellere Darstellung der SVG)
                if ($SET_tropfen > $SET_tropfen_ausblenden) {
                                $show_tropfen = false;
                }
                
                $color = $color_default;
                
                /**
                 * Zur Berechnung, vieviele Tropfen in den Kreis fallen, beobachten wir nur den Viertelkreis unten rechts
                 * Koordinaten:
                 * x = 1 - 100
                 * y = 1 - 100
                 */
                
                if ($x >= 1 && $x <= 100 && $y >= 1 && $y <= 100) {
                                
                                //Zeige Tropfen im Zielquadrat an (macht nur Sinn, wenn die anderen ausgeblendet werden)
                                $show_tropfen = true;
                                
                                
                                //Tropfen fallen zusaetzlich in Viertelkreis
                                $key = array_search($x, $arx);
                                
                                if ($x <= ($arx[$key]) && $y <= ($ary[$key])) {
                                                $color = "green";
                                                $green++;
                                } else {
                                                $color = "red";
                                                $red++;
                                }
                }
                
                
                // Weil die Platzierung innerhalb des Bildes als Nullpunkt den ersten Pixel oben links nimmt,
                // wir in der Berechnung einen Wertebereich von -100 bis +100 haben,
                // verschieben wir die Punkte auf der Zeichnung um + 100 in beide Richtungen
                $x += 100;
                $y += 100;
                
                if ($show_tropfen) {
?><circle cx="<?= $x ?>" cy="<?= $y ?>" r="0.5" stroke="<?= $color ?>" stroke-width="0.5px"/>;<?php
                                
                                // Einrueckung gemaess Verschachtelungstiefe des generierten SVG-Codes
                                echo "\n\t\t\t\t\t";
                }
}

$script_end = microtime(true);

?>
                 
                </svg>

            </fieldset>
            <?php

if (count($FEHLER) > 0) {
?>
        <fieldset>
            <legend>Fehler</legend>
            
            <?php
                foreach ($FEHLER as $k => $v) {
                                echo "[$k] $v<br>";
                }
?>
         
        </fieldset>
            
            <?php
}


$div = ($red != 0 ? ($green / $red) : 0);

?>
     
            <fieldset>
                <legend>Berechnung</legend>
                Tropfen gesamt: <?= $SET_tropfen ?> (ggf. ausserhalb des Zielqradrates ausgeblendet)<br \>
                Gr&uuml;n: <?= $green ?> / Rot: <?= $red ?> = <b><?= $div ?></b> (N&auml;herungswert dieses Simulationsdurchgangs)<br \>
                pi = <?= pi() ?> (laut php)<br \>
                Ausf&uuml;hrungszeit: <?= round($script_end - $script_start, 7) ?> Sekunden.
            </fieldset>
            
            <fieldset>
                <legend>Neue Simulation</legend>
                Tropfen: <input type="text" name="tropfen" value="<?= $SET_tropfen ?>">
                <input type="submit" value="Start">
            </fieldset>
        
        </form>
    
    </body>
</html>