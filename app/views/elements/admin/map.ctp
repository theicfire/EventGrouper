<div class="form_section">
<h2>Default Location</h2>
        
<?php echo $form->input('location', array('type' => 'text', 'class' => 'textfield'));?> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="<?php echo $html->url('/'); ?>css/rinoa_small_inline" /> Search within MIT</a> <a href="#" class="make_button"><img src="<?php echo $html->url('/'); ?>css/rinoa/zoom.png" class="<?php echo $html->url('/'); ?>css/rinoa_small_inline" /> Search Google Maps</a>
<p>As you start typing, a list of potential names will come up. We will search for this name in our database, and try to find it on a map.</p>

<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=mit&amp;sll=37.0625,-95.677068&amp;sspn=59.467068,51.064453&amp;ie=UTF8&amp;hq=Massachusetts+Institute+of+Technology&amp;hnear=Massachusetts+Institute+of+Technology,+Boston,+Suffolk,+Massachusetts+02139&amp;ll=42.360538,-71.090074&amp;spn=0.019788,0.038418&amp;output=embed"></iframe>
        
</div>