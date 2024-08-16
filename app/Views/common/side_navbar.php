<!-- Sidebar Start -->
<?php         
    $session = session();
    // echo '<pre>',print_r($approved_menu),'</pre>';
    
    foreach($approved_menu as $key=>$am){
        if($am->show_on_left_nav == 0){
            unset($approved_menu[$key]);
        }
    }

    if($session->userrole != 1){ // Normal User Level
        
        $module_master_permission = in_array('Master', array_column($approved_menu, 'menu_module'));
        $module_user_permission = in_array('User', array_column($approved_menu, 'menu_module'));
        $module_invoice_permission = in_array('Invoice', array_column($approved_menu, 'menu_module'));
        $module_report_permission = in_array('Report', array_column($approved_menu, 'menu_module'));

    } else{
        
        $module_master_permission = $module_user_permission = $module_invoice_permission = $module_report_permission = 1;
        
    }
?>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        <div class="nav-profile-image">
          <img src="<?=base_url('assets/backdesk/img/user.png')?>" alt="profile" />
          <span class="login-status online"></span>
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2"><?= $session->get('username') ?></span>
          <span class="text-secondary text-small"><?= $session->get('usertype') ?></span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <hr>
    <li class="nav-item">
      <a class="nav-link" href="<?=base_url('dashboard')?>">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="<?=base_url('user/user-profile')?>">
        <span class="menu-title">User Profile</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
    
    <?php if($module_master_permission){ ?>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#module-master" aria-expanded="false" aria-controls="page-layouts">
            <i class="p-0 m-0 mdi mdi-database-lock menu-icon"></i>&nbsp;&nbsp;
            <span class="menu-title">Master Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="module-master">
            <ul class="nav flex-column sub-menu">
                <?php 
                foreach($approved_menu as $am){
                    if($am->menu_module == "Master"){
                        ?>
                        <li class="nav-item">
                            <a href="<?= base_url('master/') . $am->menu_slug?>" class="nav-link"><?=$am->menu_name?></a>
                        </li>
                        <?php
                    }
                } 
                ?>     
            </ul>
        </div>
    </li>
    <?php } ?>  
    
    <?php if($module_invoice_permission){ ?>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#module-invoice" aria-expanded="false" aria-controls="page-layouts">
            <i class="p-0 m-0 mdi mdi-file-account-outline menu-icon"></i>&nbsp;&nbsp;&nbsp;
            <span class="menu-title">Invoice Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="module-invoice">
            <ul class="nav flex-column sub-menu">
                <?php 
                foreach($approved_menu as $am){
                    if($am->menu_module == "Invoice"){
                        ?>
                        <li class="nav-item">
                            <a href="<?= base_url('invoice/') . $am->menu_slug?>" class="nav-link"><?=$am->menu_name?></a>
                        </li>
                        <?php
                    }
                } 
                ?>     
            </ul>
        </div>
    </li>
    <?php } ?>  
    <?php if($module_report_permission){ ?>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#module-report" aria-expanded="false" aria-controls="page-layouts">
            <i class="p-0 m-0 mdi mdi-file-document menu-icon"></i>&nbsp;&nbsp;&nbsp;
            <span class="menu-title">Report Management</span>
            <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="module-report">
            <ul class="nav flex-column sub-menu">
                <?php 
                foreach($approved_menu as $am){
                    if($am->menu_module == "Report"){
                        ?>
                        <li class="nav-item">
                            <a href="<?= base_url('report/') . $am->menu_slug?>" class="nav-link"><?=$am->menu_name?></a>
                        </li>
                        <?php
                    }
                } 
                ?>     
            </ul>
        </div>
    </li>
    <?php } ?>  
  </ul>
</nav>
        