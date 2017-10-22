<?php echo $this->inc('header.php', ['title' => 'Youtube Downloader Error']); ?>
<div class="well">
	<h1 class="download-heading">Whatsapp Status Video Download Error</h1>
	<p>
		<div class="alert alert-danger">
			<?php echo $this->get('error_message'); ?></p>
		</div>
	<a class="btn btn-primary btn-lg pull-right" href="index.php">Download Again</a>
		<div class="clearfix"></div>
		<hr />
		
		<div class="clearfix"></div>
</div>
<?php echo $this->inc('footer.php'); ?>
