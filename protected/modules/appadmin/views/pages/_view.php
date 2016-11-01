<div class="post">
	<div class="title">
		<?php echo '<b>'.ucwords(CHtml::encode($data->title)).'</b>'; ?>
	</div>
	<div class="author">
		posted by <?php echo $data->author->username . ' on ' . date('F j, Y',$data->create_time); ?>
		
	</div>
	<br class="clear"/>
	<div class="content">
		<?php
			$this->beginWidget('CMarkdown', array('purifyOutput'=>true));
			echo $data->content;
			$this->endWidget();
		?>
	</div>
	<div class="nav">
		<?php if($data->commentCount>=1): ?>
		<?php echo CHtml::link("Comments ({$data->commentCount})",$data->url.'#comments'); ?> |
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
		<?php else:?>
		Last updated on <?php echo date('F j, Y',$data->update_time); ?>
		<?php endif;?>
	</div>
</div>