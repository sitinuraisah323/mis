<div class="kt-header__bottom">
		<div class="kt-container ">
		<!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
                <ul class="kt-menu__nav ">
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Dashboard</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
							<?php if(read_access('pusat')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('dashboards/pusat'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dashboard Pusat</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('area')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('dashboards/area'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dashboard Area</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('units')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('dashboards/units'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Dashboard Units</span></a>
								</li>
							<?php endif;?>
                            </ul>
                        </div>
                    </li>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Site Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
							<?php if(read_access('menu')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('site-settings/menu');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Menu</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('levels')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('site-settings/levels');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Level</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('privileges')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('site-settings/privileges');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Hak Akses</span></a>
								</li>
							<?php endif;?>
                            </ul>
                        </div>
                    </li>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Data Master</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
<<<<<<< HEAD
                            <li class="kt-menu__item "  aria-haspopup="true">
                                <a href="demo2/index.html" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pegawai</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('datamaster/customers');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Nasabah</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                                <a  href="<?php echo base_url('datamaster/areas'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Area</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('datamaster/units'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Unit</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('datamaster/mapingcategory'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Kategori Transaksi</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('datamaster/unitstarget'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Target Unit</span></a>
                            </li>
=======
							<?php if(read_access('employees')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('datamaster/employees')?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pegawai</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('customers')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/customers');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Nasabah</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('areas')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/areas'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Area</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('units')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/units'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Unit</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('unitstarget')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/unitstarget'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Target Unit</span></a>
								</li>
							<?php endif;?>
>>>>>>> 271f8e9af9f6a82d864169b13d0a7cc5df1fcf01
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="demo2/dashboards/aside.html" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">STLE</span></a>
                            </li>

                            </ul>
                        </div>
                    </li>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Transaksi</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
<<<<<<< HEAD
                            <li class="kt-menu__item "  aria-haspopup="true">
                                <a href="<?php echo base_url('transactions/unitsdailycash'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Harian Unit</span></a>
                            </li>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('transactions/regularpawns'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gadai Reguler</span></a>
							</li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('transactions/mortages');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gadai Cicilan</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('transactions/repayment'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pelunasan</span></a>
                            </li>
                            <li class="kt-menu__item "  aria-haspopup="true">
                            <a  href="<?php echo base_url('transactions/loaninstallments'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Angsuran Pinjaman Cicilan</span></a>
                            </li>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('transactions/extractall'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload Semua</span></a>
							</li>
=======
							<?php if(read_access('unitsdailycash')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('transactions/unitsdailycash'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Harian Unit</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('regularpawns')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('transactions/regularpawns'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gadai Reguler</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('mortages')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('transactions/mortages');?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Gadai Cicilan</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('repayment')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('transactions/repayment'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pelunasan</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('loaninstallments')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('transactions/loaninstallments'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Angsuran Pinjaman Cicilan</span></a>
								</li>
							<?php endif;?>
							<?php if(read_access('extractall')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('transactions/extractall'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Upload Semua</span></a>
								</li>
							<?php endif;?>
>>>>>>> 271f8e9af9f6a82d864169b13d0a7cc5df1fcf01
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- end: Header Menu -->
		</div>
	</div>

</div>
<!-- end:: Header -->
