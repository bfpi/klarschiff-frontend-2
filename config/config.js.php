/* config.js.php */
<?php
$config = include('config.php');
?>

var zoom = 2;
var lonLat_center = [11.44210, 53.61698];
var mv_bbox_25833 = [380000, 5980000, 410000, 6010000];
var extent = [232000, 5923000, 295000, 5974300];
var resolutions = [38.2185141426, 19.1092570713, 9.5546285356,
  4.7773142678, 2.3886571339, 1.194328567, 0.5971642835];

var problemMeldungenMoeglich = true;
var ideeMeldungenMoeglich = true;

var unterstuetzer_schwellenwert = <?php echo $config['thresholds']['supporter']; ?>;

var placeholder_beschreibung = "Bitte beschreiben Sie Ihre Meldung genauer.";
var placeholder_email = "Bitte geben Sie Ihre E-Mail-Adresse an.";
var placeholder_begruendung = "Bitte geben Sie eine Begründung an.";
var placeholder_freitext = "Bitte tragen Sie hier Ihr Lob, Ihre Hinweise oder Ihre Kritik zur Meldung ein.";

//// Variablen mit Fehlertexten
var hauptkategorieLeer = "Sie müssen eine Hauptkategorie auswählen.";
var unterkategorieLeer = "Sie müssen eine Unterkategorie auswählen.";
var beschreibungLeer = "Sie müssen Ihre Meldung genauer beschreiben.";
var emailFalsch = "Die angegebene E-Mail-Adresse ist syntaktisch falsch. Bitte korrigieren Sie Ihre Eingabe.";
var emailLeer = "Sie müssen Ihre E-Mail-Adresse angeben.";
var begruendungLeer = "Sie müssen eine Begründung angeben.";
var freitextLeer = "Sie müssen Ihr Lob, Ihre Hinweise oder Ihre Kritik zur Meldung angeben.";

var mapUrl = 'map.php';

var styleCache = {};
var highlightStyleCache = {};
ol_styles = {
  stroke: new ol.style.Stroke({
    color: "#FF8700",
    width: 2
  }),
  beobachtungsflaeche: function(feature, resolution) {
    var text = resolution < 25 ? feature.get("bezeichnung") : "";
    if (!styleCache[text]) {
      styleCache[text] = [new ol.style.Style({
          stroke: ol_styles.stroke,
          fill: new ol.style.Fill({
            color: "rgba(255,135,0,0.5)"
          }),
          text: new ol.style.Text({
            font: "bold 11px Verdana",
            text: text,
            stroke: new ol.style.Stroke({
              color: "#FFFFFF",
              width: 3
            }),
            fill: new ol.style.Fill({
              color: "#FF8700"
            })
          })
        })];
    }
    return styleCache[text];
  },
  beobachtungsflaeche_hover: function(feature, resolution) {
    var text = resolution < 5000 ? feature.get("bezeichnung") : "";
    if (!highlightStyleCache[text]) {
      highlightStyleCache[text] = [new ol.style.Style({
          stroke: ol_styles.stroke,
          fill: new ol.style.Fill({
            color: "rgba(255,0,255,0.3)"
          }),
          text: new ol.style.Text({
            font: "bold 13px Verdana",
            text: text,
            stroke: new ol.style.Stroke({
              color: "#FFFFFF",
              width: 3
            }),
            fill: new ol.style.Fill({
              color: "#FF00FF"
            })
          })
        })];
    }
    return highlightStyleCache[text];
  }
};

var ol_config = {
  "layers": {
    "Stadtplan": {
      type: "TileWMTS",
      title: "Stadtplan",
      url: "http://www.geodaten-mv.de/dienste/orka_wmts/wmts/{layer}/{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png",
      visibility: true,
      layers: "orkamv",
      tileGridOrigin: [-464849.38, 6310160.14],
      matrixSet: "epsg_25833_adv",
      matrixIds: [7, 8, 9, 10, 11, 12, 13],
      requestEncoding: "REST",
      projection: "EPSG:25833",
      format: "image/png",
      attribution_text: 'Kartenbild ©Landeshauptstadt Schwerin (<a href="http://creativecommons.org/licenses/by/3.0/deed.de" target="_blank" style="color:#006CB7;text-decoration:none;">CC BY 3.0</a>) | Kartendaten © <a href="http://www.openstreetmap.org/" target="_blank" style="color:#006CB7;text-decoration:none;">OpenStreetMap</a> (<a href="http://opendatacommons.org/licenses/odbl/" target="_blank" style="color:#006CB7;text-decoration:none;">ODbL</a>) und <a href="https://geo.sv.rostock.de/uvgb.html" target="_blank" style="color:#006CB7;text-decoration:none;">uVGB-MV</a>',
      default_layer: true,
      displayInLayerSwitcher: true
    },
    Luftbild: {
      type: "TileWMTS",
      title: "Luftbild",
      url: "http://www.geodaten-mv.de/dienste/dop_wmts/wmts/{layer}/{TileMatrixSet}/{TileMatrix}/{TileCol}/{TileRow}.png",
      visibility: true,
      layers: "mv_dop",
      tileGridOrigin: [-464849.38, 6310160.14],
      matrixSet: "ETRS89UTM33",
      matrixIds: [7, 8, 9, 10, 11, 12, 13],
      requestEncoding: "REST",
      projection: "EPSG:25833",
      format: "image/png",
      attribution_text: "© GeoBasis-DE/M-V",
      default_layer: false,
      displayInLayerSwitcher: true
    },
//    "POI": {
//      type: "ImageWMS",
//      url: "http://geo.sv.rostock.de/geodienste/klarschiff_poi/ows?",
//      version: "1.1.1",
//      layers: "abfallbehaelter,ampeln,beleuchtung,brunnen,denkmale,hundetoiletten,recyclingcontainer,sitzgelegenheiten,sperrmuelltermine",
//      projection: "EPSG:25833",
//      format: "image/png",
//      default_layer: true,
//      minScale: 1100,
//      singleTile: true
//    },
    "Meldungen": {
      title: "Meldungen",
      type: "Vector",
      url: "<?php echo MELDUNGEN_WFS_URL; ?>",
      default_layer: true,
      enableClustering: true,
      clusterDistance: 40,
      style: meldungenStyles,
      url_with_filter: function() {
        if (this.filter === undefined) {
          return this.url;
        }
        if (this.filter == null) {
          return null;
        }
        return this.url + "&Filter=" + this.filter;
      },
      eventHandlers: {
	      change: function(evt) {
          if (typeof(map.showAdvice) === "function") {
            var features = evt.currentTarget.getSource().getFeatures();
            if (features.length > 0) {
              map.showAdvice(features);
            }
          }
	      }
      }
    },
    "SketchMeldung": {
      title: "SketchMeldung",
      type: "Vector",
      default_layer: true
    },
    "SketchBeobachtungsflaeche": {
      title: "SketchBeobachtungsflaeche",
      type: "Vector",
      url: "<?php echo STADTTEILE_WFS_URL; ?>",
      default_layer: false,
      style: ol_styles.beobachtungsflaeche
    },
    "DrawBeobachtungsflaeche": {
      title: "DrawBeobachtungsflaeche",
      type: "Vector",
      default_layer: false,
      style: ol_styles.beobachtungsflaeche
    }
  }
};

var mapicons_config = {};

if (problemMeldungenMoeglich) {
  var problem_mapicons_config = {
    probleme12: {
      icons: ["problem_1_layer.png", "problem_2_layer.png"],
      label: "offene Probleme",
      checked: true,
      filter: {
        vorgangstyp: "problem",
        status: ["gemeldet", "offen"]
      }
    },
    probleme3: {
      icons: ["problem_3_layer.png"],
      label: "Probleme in Bearbeitung",
      checked: true,
      filter: {
        vorgangstyp: "problem",
        status: "inBearbeitung"
      }
    },
    probleme4: {
      icons: ["problem_4_layer.png"],
      label: "nicht lösbare Probleme",
      checked: true,
      filter: {
        vorgangstyp: "problem",
        status: "wirdNichtBearbeitet"
      }
    },
    probleme5: {
      icons: ["problem_5_layer.png"],
      label: "gelöste Probleme",
      checked: true,
      filter: {
        vorgangstyp: "problem",
        status: "abgeschlossen"
      }
    }
  };
  mapicons_config = $.extend(mapicons_config, problem_mapicons_config);
}
if (ideeMeldungenMoeglich) {
  var idee_mapicons_config = {
    ideen12: {
      icons: ["idee_1_layer.png", "idee_2_layer.png"],
      label: "offene Ideen",
      checked: true,
      filter: {
        vorgangstyp: "idee",
        status: ["gemeldet", "offen"]
      }
    },
    ideen3: {
      icons: ["idee_3_layer.png"],
      label: "Ideen in Bearbeitung",
      checked: true,
      filter: {
        vorgangstyp: "idee",
        status: "inBearbeitung"
      }
    },
    ideen4: {
      icons: ["idee_4_layer.png"],
      label: "nicht umsetzbare Ideen",
      checked: true,
      filter: {
        vorgangstyp: "idee",
        status: "wirdNichtBearbeitet"
      }
    },
    ideen5: {
      icons: ["idee_5_layer.png"],
      label: "umgesetzte Ideen",
      checked: true,
      filter: {
        vorgangstyp: "idee",
        status: "abgeschlossen"
      }
    }
  };
  mapicons_config = $.extend(mapicons_config, idee_mapicons_config);
}

// JQuery-UI konfigurieren
if ($.ui !== undefined) {
  $.ui.dialog.prototype.options.closeText = "Schließen";
}
