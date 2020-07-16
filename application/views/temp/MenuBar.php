<div class="kt-header__bottom">
		<div class="kt-container ">
		<!-- begin: Header Menu -->
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
        <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
                <ul class="kt-menu__nav ">
				
					<?php if(read_access('Dashboard')):?>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Dashboard</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('dashboards'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Outstanding</span></a>
								</li>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('dashboards/pelunasan'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pelunasan</span></a>
								</li>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a href="<?php echo base_url('dashboards/pencairan'); ?>" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i><span class="kt-menu__link-text">Pencairan</span></a>
								</li>
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
					<?php endif;?>

					<?php if(read_access('site-settings')):?>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Site Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
							<?php if(read_access('menu')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('site-settings/menu'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Menu</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('levels')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('site-settings/levels'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Level</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('privileges')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('site-settings/privileges'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Hak Akses</span>
								</a>
							</li>
							<?php endif;?>							
                            </ul>
                        </div>
                    </li>
					<?php endif;?>
					
					<?php if(read_access('datamaster')):?>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Data Master</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
							<?php if(read_access('employees')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('datamaster/employees'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Pegawai</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('customers')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('datamaster/customers'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Nasabah</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('areas')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('datamaster/areas'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Area</span>
								</a>
							</li>
							<?php endif;?>

							<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
								<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
									<span class="kt-menu__link-text">Units</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
									<ul class="kt-menu__subnav">
									<?php if(read_access('units')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/units'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Unit</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('unitstarget')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/unitstarget'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
													<span class="kt-menu__link-text">Target Unit</span>
											</a>
										</li>	
										<?php endif;?>		
										<?php if(read_access('stle')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/stle'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
													<span class="kt-menu__link-text">STLE</span>
											</a>
										</li>	
										<?php endif;?>							
									</ul>
								</div>
							</li>

							<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
								<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
									<span class="kt-menu__link-text">Kategori</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
									<ul class="kt-menu__subnav">
									<?php if(read_access('mapingcategory')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/mapingcategory'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Transaksi</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('mappingcase')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/mappingcase'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
													<span class="kt-menu__link-text">No. Perk</span>
											</a>
										</li>	
										<?php endif;?>								
									</ul>
								</div>
							</li>

							<?php if(read_access('users')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('datamaster/users'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Users</span>
								</a>
							</li>
							<?php endif;?>

							<?php if(read_access('bookcash')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/fractionofmoney'); ?>" class="kt-menu__link ">
										<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
										<span class="kt-menu__link-text">Pecahan Uang</span>
									</a>
								</li>
							<?php endif;?>

							<?php if(read_access('bookcash')):?>
								<li class="kt-menu__item "  aria-haspopup="true">
									<a  href="<?php echo base_url('datamaster/bookcash'); ?>" class="kt-menu__link ">
										<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
										<span class="kt-menu__link-text">buku kas</span>
									</a>
								</li>
							<?php endif;?>

							</ul>
                        </div>
                    </li>
					<?php endif;?>

					<?php if(read_access('transactions')):?>
                    <li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Transaksi</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">
							<?php if(read_access('regularpawns')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('transactions/unitsdailycash'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Kas Unit</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('regularpawns')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('transactions/regularpawns'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Gadai Reguler</span>
								</a>
							</li>
							<?php endif;?>
							<?php if(read_access('mortages')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('transactions/mortages'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Gadai Cicilan</span>
								</a>
							</li>
							<?php endif;?>						
							
                            </ul>
                        </div>
                    </li>
					<?php endif;?>

					<?php if(read_access('report')):?>
					<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                    <a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Report</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
                        <div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
                            <ul class="kt-menu__subnav">					

							<?php if(read_access('regularpawns')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('report/regularpawns'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Gadai Reguler</span>
								</a>
							</li>
							<?php endif;?>
							
							<?php if(read_access('mortages')):?>
							<li class="kt-menu__item "  aria-haspopup="true">
								<a  href="<?php echo base_url('report/mortages'); ?>" class="kt-menu__link ">
									<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
									<span class="kt-menu__link-text">Gadai Cicilan</span>
								</a>
							</li>
							<?php endif;?>

							<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
								<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
									<span class="kt-menu__link-text">Modal Kerja</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
									<ul class="kt-menu__subnav">
									<?php if(read_access('antarunit')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/modalkerja/pusat'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Kantor Pusat</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('antarunit')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/modalkerja/antarunit'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
													<span class="kt-menu__link-text">Mutasi Antar Unit</span>
											</a>
										</li>	
										<?php endif;?>									
									</ul>
								</div>
							</li>

							<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
								<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
									<span class="kt-menu__link-text">Jurnal</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
								</a>
								<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
									<ul class="kt-menu__subnav">
									<?php if(read_access('pencairan')):?>
										<!-- <li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php //echo base_url('report/pencairan'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Pencairan</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('pelunasan')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php //echo base_url('report/pelunasan'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Pelunasan</span>
											</a>
										</li> -->
										<?php endif;?>
										<?php if(read_access('pendapatan')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/pendapatan'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Pendapatan</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('pengeluaran')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/pengeluaran'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Pengeluaran</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('kantorpusat')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/bukukas'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
												<span class="kt-menu__link-text">Buku kas</span>
											</a>
										</li>
										<?php endif;?>
										<?php if(read_access('mutasiunits')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/bukubank'); ?>" class="kt-menu__link ">
												<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
													<span class="kt-menu__link-text">Buku Bank</span>
											</a>
										</li>	
										<?php endif;?>					
									</ul>
								</div>
							</li>
							<?php if(read_access('mutasiunits')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/dpd'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Nasabah DPD</span>
											</a>
										</li>
										<?php endif;?>
							</ul>
                        </div>
                    </li>
					<?php endif;?>
                </ul>
            </div>

			<div class="kt-header-toolbar">

				<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
            	<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
                	<ul class="kt-menu__nav ">
                    	<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
							<a  href="<?php echo base_url('dailyreport/unitsreport'); ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> Non OJK</a>&nbsp
							<a  href="<?php echo base_url('dailyreport/unitsreportojk'); ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> OJK</a>&nbsp
                    	<a  href="#"  data-toggle="modal" data-target="#help" class="btn btn-success"><i class="fa fa-exclamation-circle"></i> Help</a>
                    	</li>
					</ul>
				</div>
				</div>
			</div>

        </div>
        <!-- end: Header Menu -->
		</div>
	</div>

</div>
<!-- end:: Header -->
