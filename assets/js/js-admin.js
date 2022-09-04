jQuery(function() {
  jQuery('#personphonecode').select2();

  var scntDiv = jQuery('#p_scents');
  var i = jQuery('#p_scents p').size() + 1;

  jQuery(document).on('click', '#addScnt', function() {
    jQuery('<p><label for="p_scnts"><input type="text" id="p_scnt" size="20" name="p_scnt_' + i + '" value="" placeholder="Input Value" /></label> <a href="#" class="remScnt">Remove</a></p>').appendTo(scntDiv);
    i++;
    return false;
  });

  jQuery(document).on('click', '.remScnt', function() {
    if (i > 2) {
      jQuery(this).closest('p').remove();
      i--;
    }

    return false;
  });
});