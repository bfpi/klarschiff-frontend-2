<form id="meldung" action="php/meldung_submit.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="task" value="submit"/>
  <input type="hidden" name="typ" value="${typ}"/>
  <input type="hidden" name="point" value="${point}"/>

  <h4 style="margin-bottom:8px;margin-top:2px">Pflichtangaben</h4>
  <div style="margin-bottom:18px">
    <label for="hauptkategorie" class="required" style="margin-bottom:3px">Hauptkategorie</label>
    <select name="hauptkategorie">
    </select>

    <label for="unterkategorie" class="required" style="margin-bottom:3px">Unterkategorie</label>
    <select name="unterkategorie">
    </select>

    <label for="email" class="required" style="margin-bottom:3px">E-Mail-Adresse</label>
    <input type="text" maxlength="255" name="email" value="${email}"/>
  </div>

  <h4 style="margin-bottom:8px">weitere Angaben</h4>	
  <label for="beschreibung" style="margin-bottom:3px">Beschreibung</label>
  <textarea name="beschreibung">${beschreibung}</textarea>

  <label for="foto" style="margin-bottom:3px">Foto</label>
  <input type="file" name="foto"/>
  <table id="fotos"></table>

  <p class="help"><b>Hinweis:</b> Vor der Veröffentlichung werden eingegebene Texte sowie das Foto redaktionell überprüft.</p>

</form>
