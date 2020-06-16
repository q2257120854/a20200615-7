  <footer data-am-widget="footer"
          class="am-footer am-footer-default"
          data-am-footer="{  }">
    <div class="am-footer-switch">
        友情链接：
	<?php 
	$link = $this->links;
	if($link):?>
	<?php foreach($link as $key=>
	$val):?>
	<span class="am-footer-divider"> | </span>
	<a class="am-footer-desktop" href="<?php echo $val['url']?>" target="_blank">
	<?php echo $val['title']?>
	</a>
	<?php endforeach;?>
	<?php endif;?>
    </div>
    
    <div class="am-footer-miscs ">
      <p><?php echo $this->config['copyright']?></p>
      <p><?php echo $this->config['icpcode']?></p>
      <p><?php echo $this->config['tel']?></p>
    </div>
  </footer>

  <div id="am-footer-modal"
       class="am-modal am-modal-no-btn am-switch-mode-m am-switch-mode-m-default">
    <div class="am-modal-dialog">
      <div class="am-modal-hd am-modal-footer-hd">
        <a href="javascript:void(0)" data-dismiss="modal" class="am-close am-close-spin " data-am-modal-close>&times;</a>
      </div>
      <div class="am-modal-bd">
		<?php echo $this->config['copyright']?>
		<?php echo $this->config['icpcode']?>
		<?php echo $this->config['tel']?>
	
      </div>
    </div>
  </div>
 <?php if ($this->config['mp3_state']=='1'){ ?> 
<link rel="stylesheet" href="/static/player.css" />
<div id="QPlayer">
<div id="pContent">
	<div id="player">
		<span class="cover"></span>
		<div class="ctrl">
			<div class="musicTag marquee">
				<strong>歌名</strong>
				<span> - </span>
				<span class="artist">歌手</span>
			</div>
			<div class="progress">
				<div class="timer left">0:00</div>
				<div class="contr">
					<div class="rewind icon"></div>
					<div class="playback icon"></div>
					<div class="fastforward icon"></div>
				</div>
				<div class="right">
					<div class="liebiao icon"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="ssBtn">
	        <div class="adf"></div>
    </div>
</div>
<ol id="playlist"></ol>
</div>

<!--音乐-->  
<script>var	playlist = [
<?php echo $this->config['mp3list']?>
];
  var isRotate = true;
  var autoplay = true;
  </script>
<script type="text/javascript" src="/static/player.js"></script>
<?php } ?>
<script src="/static/default/assets/js/app.js"></script>
<script src="/static/default/js/app.js"></script>

<?php echo $this->config['stacode']?>
</body>
</html>