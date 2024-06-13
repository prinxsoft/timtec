    
    <div id="footerwrap">
		<div id="footer">
             <p> All Rights Reserved  &copy;  <?php echo '2014-'.date("Y"); ?>. Powered by: PDU ICTREC </p>
</div>
    </div>
    

</div> 

<script>
  // JavaScript/jQuery
  $(document).ready(function() {
    $('.mark').on('click', function() {
      var markedText = $('<div>').text('Marked').hide();
      $(this).append(markedText);
      markedText.slideDown(5000, function() {
        markedText.delay(2000).slideUp(500);
      });
    });

    $('#search').on('keyup', function() {
      var value = $(this).val().toLowerCase(); // Get the search term

      // Filter table rows based on search term
      var recordCount = 0;
      $('.greenTable tr').each(function() {
        if ($(this).index() === 0) {
          // Always show the first row (fields row)
          $(this).show();
        } else {
          var rowText = $(this).text();
          var showRow = rowText.toLowerCase().indexOf(value) > -1;
          $(this).toggle(showRow);
          if (showRow) {
            recordCount++;
          }
        }
      });

      // Update record count in the search input placeholder
      $('#recordCount').text(' (Records found: ' + recordCount + ')');
    });
  });
</script>


</body>
</html>