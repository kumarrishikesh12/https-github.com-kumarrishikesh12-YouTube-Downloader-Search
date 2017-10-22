<?php echo $this->inc('header.php', ['title' => 'Whatsapp Status Video Download']); ?>
<div class="well">
	<h1 class="alert alert-danger download-heading text-center">Whatsapp Status Video Download </h1>
	<hr />
	<div id="">	
	 <h2 class="alert alert-info text-center"><?php echo $this->get('video_title'); ?></h2>
	</div>
	<br>

	<?php if ($this->get('show_thumbnail') === true) { ?>
	 
		<a href="<?php echo $this->get('thumbnail_anchor'); ?>" target="_blank">
		
		<img class="img-responsive center-block" src="<?php echo $this->get('thumbnail_anchor'); ?>" width="480px" height="360px" border="0" hspace="2" vspace="2">
	     </a>  
		<!-- <iframe class="center-block" width="480px" height="360px" src="< ?php echo $_GET['videoid']; ?>"> </iframe> -->
    
		<?php //echo $_GET['videoid']; ?>
    

    <?php } ?>


	<br>
<?php if ($this->get('no_stream_map_found', false) === true) { ?>
	<p>No encoded format stream found.</p>
	<p>Here is what we got from YouTube:</p>
	<pre>
		<?php echo $this->get('no_stream_map_found_dump'); ?>
	</pre>
<?php }
else
{ ?>
<?php if ($this->get('show_debug1', false) === true) { ?>
	<pre>
		<?php echo $this->get('debug1'); ?>
	</pre>
<?php } ?>


<?php if ($this->get('show_debug2', false) === true) { ?>
	<p>These links will expire at <?php echo $this->get('debug2_expires'); ?></p>
	<p>The server was at IP address <?php echo $this->get('debug2_ip'); ?> which is an <?php echo $this->get('debug2ipbits'); ?> bit IP address. Note that when 8 bit IP addresses are used, the download links may fail.</p>
<?php } ?>



	<h2 class="alert alert-info text-center">List of available formats for download</h2>
	<ul class="dl-list">

<?php foreach($this->get('streams', []) as $format) { ?>
		<li>
			<span class="col-sm-3">
			<a class="btn btn-default btn-type disabled" href="#"><?php echo $format['type']; ?> - <?php echo $format['quality']; ?></a>
			</span>

<span class="col-sm-3">
		<div class="label label-warning"><?php echo $format['size']; ?></div>
</span>


<?php if ($format['show_direct_url'] === true) { ?>
			
			<span class="col-sm-3">
			<a class="btn btn-default btn-download" href="<?php echo $format['direct_url']; ?>" class="mime"><i class="glyphicon glyphicon-download-alt"></i> Direct Download</a>
			</span>
<?php } ?>


<?php if ($format['show_proxy_url'] === true) { ?>
			
		 <a class="btn btn-primary btn-download" href="<?php echo $format['proxy_url']; ?>" class="mime"><i class="glyphicon glyphicon-download-alt"></i> Proxy Download</a>
		   
<?php } ?>
		
			
		</li>
<?php } ?>

	</ul>


	<hr />
	

	<h2 class="alert alert-info text-center">Separated video and audio format</h2>
	<ul class="dl-list">
<?php foreach($this->get('formats', []) as $format) { ?>
	<li>
		<span class="col-sm-3">
		<a class="btn btn-default btn-type disabled" href="#"><?php echo $format['type']; ?> - <?php echo $format['quality']; ?></a>
	    </span>

<span class="col-sm-3">
<div class="label label-warning"><?php echo $format['size']; ?></div>
</span>


<?php if ($format['show_direct_url'] === true) { ?>

<span class="col-sm-3">
		<a class="btn btn-default btn-download" href="<?php echo $format['direct_url']; ?>" class="mime"><i class="glyphicon glyphicon-download-alt"></i> Direct Download</a>
</span>

<?php } ?>



<?php if ($format['show_proxy_url'] === true) { ?>
		<a class="btn btn-primary btn-download" href="<?php echo $format['proxy_url']; ?>" class="mime"><i class="glyphicon glyphicon-download-alt"></i> Proxy Download</a>
<?php } ?>
		
	</li>
<?php } ?>
	</ul>


<?php if ($this->get('showMP3Download', false) === true) { ?>
	<h2>Convert and Download to .mp3</h2>
	<ul class="dl-list">
		<li>
			<a class="btn btn-default btn-type disabled" href="#" class="mime">audio/mp3 - <?php echo $this->get('mp3_download_quality'); ?></a>
			<a class="btn btn-primary btn-download" href="<?php echo $this->get('mp3_download_url'); ?>" class="mime"><i class="glyphicon glyphicon-download-alt"></i> Convert and Download</a>
		</li>
	</ul>
<?php } ?>
	<hr />
	<p class="alert alert-info">Note: that you initiate download either by clicking "Direct" to download from the origin server or by clicking "Proxy" to use this server as proxy.</p>

<?php } ?>
<hr />

	<div class="clearfix"></div>
</div>
<?php echo $this->inc('footer.php'); ?>
