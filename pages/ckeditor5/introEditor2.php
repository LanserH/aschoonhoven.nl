<label class="formLabel">Overtuig uw klant met een <strong>korte introductie</strong> tekst van maximaal 120 woorden om contact met u op te nemen:</label>
<div class="spanToelichtingLabel">            
	<ol>
		<li><strong>Bold</strong> is enkel alleen bedoeld om enkele woorden of zinsdelen te benadrukken.</li>
		<li><em>Italic</em> is enkel alleen bedoeld om een woord in een zin te benadrukken.</li>
		<li>Een link moet een goede beschrijving hebben. Linkdoel "<a href="#">klik hier</a>" bij voorkeur vermijden.</li>
		<li>Quote is enkel alleen bedoeld om een citaat te benadrukken.</li>
	</ol> 
</div>
<div class="centered">
	<div id="editor2">
		<?php echo $intro['introTekst2'];?>
	</div>
</div>
<script>
	ClassicEditor
		.create( document.querySelector( '#editor2' ), {
			toolbar: [ 'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', '|', 'blockQuote', /*'insertTable', 'mediaEmbed',*/ '|', 'undo', 'redo' ]
		} )
		.then( editor => {
			window.editor2 = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>

