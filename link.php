<?php
/**
* 友情链接
*
* @package custom
*/
$this -> need('header.php');
?>


	<div id="links">

<div id="page-header" style="background-image:url(<?php  $this->fields->imgurl(); ?>);">
		<div id="page-header-mask">
			<div id="page-header-content">
				<h2 id="page-content-title"><?php $this->title();?></h2>			
       			</div>
		</div>
    </div>

		<div id="links-content">
			<h2>ともだち</h2>
	    <div class="friends">
				<?php if (isset($this->options->plugins['activated']['Links'])) : ?>
					<?php Links_Plugin::output("
					<li class='clear'>
						<a href='{url}' target='_blank'><img src='{image}' alt='{name}'/></a>
						<div class='link-item-content'>
							<h3>{name}</h3>
							<span>{sort}</span>
							<p>{description}</p>
						</div>
					</li>
					", 0); ?>
				<?php endif ?>

				<?php $this->content();?>

		</div>
	</div>
  </div>
<?php $this -> need('footer.php'); ?>
