<!-- START RIGHT CONTENT - Widget menu -->    
  <div class="grid_3">
  <!-- TODO WIDGET -->
  	<div class="widget" id="todo">
	  <?php if(isset($_SESSION['isLogged'])){ ?>
	  <?php if(isset($_SESSION['isAdmin'])){ ?>
   	  <h3 class="todo">Admin Panel</h3>
	  <p class="todoitem"><a class="view_all" href="adm.home.php" >Home</a></p>
	  <p class="todoitem"><a class="view_all" href="adm.user.php" >User Manager</a><a class="close" href="#">X</a></p>
          <p class="todoitem"><a class="view_all" href="adm.setting.php" >Setting</a><a class="close" href="#">X</a></p>
	  <p class="todoitem"><a class="view_all" href="logout.php" >logOut</a></p>
        <?php } ?>
	
	<h3 class="todo">Navigasi</h3>
	<p class="todoitem"><a class="view_all" href="adm.home.php" >Home</a></p>
	<?php if($_SESSION['isAdmin']==0){ ?>
            <?php foreach($_config['menu'] as $menu){ ?>
                <?php if(array_key_exists($menu[0],$_SESSION['pages']) && $_SESSION['pages'][$menu[0]]==1 ){?>
		    <p class="todoitem"><a class="view_all" href="<?php echo $menu[2];?>"><?php echo $menu[1];?></a><a class="close" href="#">X</a></p>
			
                    		<?php }?>
                    	<?php }?>
                    <?php }else{ ?>
                    	<?php foreach($_config['menu'] as $menu){ ?>
					<p class="todoitem"><a class="view_all" href="<?php echo $menu[2];?>"><?php echo $menu[1];?></a><a class="close" href="#">X</a></p>
                                        
        
                        <?php }?>
                        
                    <?php }?>
	
      <?php } ?>
      <p class="todoitem"><a class="view_all" href="logout.php">Logout</a></p>
      </div>
  </div>
  <!-- end .grid_13 - RIGHT CONTENT - Widget menu  -->