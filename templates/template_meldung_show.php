<input type="hidden" name="id" value="${id}"/>
<input type="hidden" name="zustaendigkeit" value="${zustaendigkeit}"/>
<div id="supporters">
  <p>bisher<span class="meldung_unterstuetzer">${unterstuetzer}</span>{%if unterstuetzer != 1%}Unterstützungen{%/if%}{%if unterstuetzer == 1%}Unterstützung{%/if%}{%if vorgangstyp == 'idee'%}<br/>(${schwellenwert} nötig){%/if%}</p>
</div>
Hauptkategorie
<p class="meldung_eintrag">${hauptkategorie}</p>

Unterkategorie
<p class="meldung_eintrag">${unterkategorie}</p>

Status
<p class="meldung_eintrag">${status} (seit ${datum_statusaenderung}){%if status != 'gemeldet' %}, aktuell bei<br/>${zustaendigkeit}{%/if%}</p>
<div id="meldung_details">
  {%if bemerkung%}
  Statusinformation
  <p class="meldung_eintrag">{%html bemerkung%}</p>
  {%/if%}
  {%if (beschreibung_vorhanden == true || beschreibung_vorhanden == 't') && (beschreibung_freigegeben == true || beschreibung_freigegeben == 't')%}
  Beschreibung
  <p class="meldung_eintrag">${beschreibung}</p>
  {%elif status == 'offen' && (beschreibung_vorhanden == true || beschreibung_vorhanden == 't') && (beschreibung_freigegeben == false || beschreibung_freigegeben == 'f')%}
  Beschreibung
  <p class="meldung_eintrag-nicht-vorhanden">redaktionelle Prüfung ausstehend</p>
  {%elif status != 'offen' && status != 'gemeldet' && (beschreibung_vorhanden == true || beschreibung_vorhanden == 't') && (beschreibung_freigegeben == false || beschreibung_freigegeben == 'f')%}
  Beschreibung
  <p class="meldung_eintrag-nicht-vorhanden">redaktionell nicht freigegeben</p>
  {%/if%}

  {%if (foto_vorhanden == true || foto_vorhanden == 't') && (foto_freigegeben == true || foto_freigegeben == 't')%}
  Foto
  <div class="meldung-foto">
    <img src="<?php echo BASE_URL; ?>fotos/${foto_normal}" />
  </div>
  {%elif status == 'offen' && (foto_vorhanden == true || foto_vorhanden == 't') && (foto_freigegeben == false || foto_freigegeben == 'f')%}
  Foto
  <p class="meldung_eintrag-nicht-vorhanden">redaktionelle Prüfung ausstehend</p>
  {%elif status != 'offen' && status != 'gemeldet' && (foto_vorhanden == true || foto_vorhanden == 't') && (foto_freigegeben == false || foto_freigegeben == 'f')%}
  Foto
  <p class="meldung_eintrag-nicht-vorhanden">redaktionell nicht freigegeben</p>
  {%/if%}

  <p class="meldung_eintrag">bisher <span class="meldung_unterstuetzer">${unterstuetzer}</span> {%if unterstuetzer != 1%}Unterstützungen{%/if%}{%if unterstuetzer == 1%}Unterstützung{%/if%}{%if vorgangstyp == 'idee'%} (${schwellenwert} nötig){%/if%}</p>
  <div id="meldung_actions" class="ui-dialog-buttonpane ui-widget-content ui-helper-clearfix">
    <button id="meldung_unterstuetzen" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false">
      <span style="line-height:8px" class="ui-button-text">Meldung unterstützen</span>
    </button>
    <button id="meldung_melden" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false">
      <span style="line-height:8px"class="ui-button-text">Missbrauch melden</span>
    </button>
    <br/>
    <button id="meldung_lobenhinweisenkritisieren" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false" style="width:97.5%">
      <span style="line-height:8px"class="ui-button-text">Lob, Hinweise oder Kritik zur Meldung</span>
    </button>
  </div>
</div>
<div>
  <button id="meldung_details_show">Details</button>
  <button id="meldung_details_prev" title="Vorherige Meldung anzeigen" style="display:none;">
    <span class="ui-icon ui-icon-seek-prev"></span>
  </button>
  <span id="meldung_details_recorder" style="display:none;"></span>
  <button id="meldung_details_next" title="Nächste Meldung anzeigen" style="display:none;">
    <span class="ui-icon ui-icon-seek-next"></span>
  </button>
</div>
