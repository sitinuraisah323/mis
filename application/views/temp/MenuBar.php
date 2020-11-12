<div class="kt-header__bottom">
	<div class="kt-container ">
		<!-- begin: Header Menu -->
		<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
		<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
			<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile "  >
				<ul class="kt-menu__nav ">

					<?php if(read_access('Dashboards')):?>
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
							<a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Dashboard</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">

								<?php if($this->session->userdata('user')->level == 'administrator' || $this->session->userdata('user')->level == 'area' || $this->session->userdata('user')->level == 'pusat'):?>
									<?php if(read_access('dashboards')):?>
										<!-- <li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php //echo base_url('dashboards'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Dashboard</span>
											</a>
										</li> -->

										<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
											<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
											<span class="kt-menu__link-icon">
											<i class="fa fa-chart-bar"><span></span></i>
											</span>
													<span class="kt-menu__link-text">Dashboard</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
												</a>
												<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
													<ul class="kt-menu__subnav">
														<?php if(read_access('dashboards')):?>
															<li class="kt-menu__item "  aria-haspopup="true">
																<a  href="<?php echo base_url('dashboards'); ?>" class="kt-menu__link ">
																	<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																	<span class="kt-menu__link-text">GHA Nasional</span>
																</a>
															</li>
														<?php endif;?>
														<?php if(read_access('dashboards/ojk')):?>
															<li class="kt-menu__item "  aria-haspopup="true">
																<a  href="<?php echo base_url('dashboards/ojk'); ?>" class="kt-menu__link ">
																	<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																	<span class="kt-menu__link-text">GHA OJK Nasional</span>
																</a>
															</li>
														<?php endif;?>
														<?php if(read_access('dashboards/nonojk')):?>
															<li class="kt-menu__item "  aria-haspopup="true">
																<a  href="<?php echo base_url('dashboards/nonojk'); ?>" class="kt-menu__link ">
																	<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																	<span class="kt-menu__link-text">GHA NON OJK Nasional</span>
																</a>
															</li>
														<?php endif;?>
													</ul>
												</div>
											</li>
									<?php endif;?>
								<?php endif;?>

								<?php if($this->session->userdata('user')->level == 'unit'):?>
									<?php if(read_access('dashboards/unit')):?>
									<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/unit'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Dashboard</span>
											</a>
										</li>
										<?php endif;?>
								<?php endif;?>								
									<?php if($this->session->userdata('user')->level == 'pusat' || $this->session->userdata('user')->level == 'area'):?>
									<?php if(read_access('dashboards')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Dashboard</span>
											</a>
										</li>
									<?php endif;?>
									<?php endif;?>
									<?php if(read_access('dashboards/executivesummary')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/executivesummary'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Executive Summary</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('dashboards/outstanding')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/outstanding'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Outstanding</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('dashboards/pelunasan')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/pelunasan'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Pelunasan</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('dashboards/pencairan')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/pencairan'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">Pencairan</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('dashboards/dpd')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('dashboards/dpd'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
												<span class="kt-menu__link-text">DPD</span>
											</a>
										</li>
									<?php endif;?>
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('dashboards/realisasi'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
											<span class="kt-menu__link-text">Realisasi</span>
										</a>
									</li>
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('dashboards/pendapatan'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-chart-bar"><span></span></i></span>
											<span class="kt-menu__link-text">Pendapatan</span>
										</a>
									</li>									
								</ul>
							</div>
						</li>
					<?php endif;?>

					<?php if(read_access('site-settings')):?>
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
							<a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Site Setting</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<?php if(read_access('site-settings/menu')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('site-settings/menu'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Menu</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('site-settings/levels')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('site-settings/levels'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Level</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('site-settings/privileges')):?>
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
									<?php if(read_access('datamaster/employees')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/employees'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Pegawai</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('datamaster/customers')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/customers'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Nasabah</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('datamaster/groups')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/groups'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Group</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('datamaster/areas')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/areas'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Area</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('datamaster/unitstarget')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/unitstarget'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Unit Target</span>
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
												<?php if(read_access('datamaster/units')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('datamaster/units'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Unit</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('datamaster/unitstarget')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('datamaster/unitstarget'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Target Unit</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('datamaster/stle')):?>
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
												<?php if(read_access('datamaster/mapingcategory')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('datamaster/mapingcategory'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Transaksi</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('datamaster/mappingcase')):?>
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
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('datamaster/logammulya'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
											<span class="kt-menu__link-text">Logam Mulya</span>
										</a>
									</li>
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('datamaster/grams'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
											<span class="kt-menu__link-text">Grams</span>
										</a>
									</li>

									<?php if(read_access('datamaster/users')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/users'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Users</span>
											</a>
										</li>
									<?php endif;?>

									<?php if(read_access('datamaster/fractionofmoney')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/fractionofmoney'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Pecahan Uang</span>
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
									<?php if(read_access('transactions/unitsdailycash')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('transactions/unitsdailycash'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Kas Unit</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('transactions/regularpawns')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('transactions/regularpawns'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Gadai Reguler</span>
											</a>
										</li>
									<?php endif;?>
									<?php if(read_access('transactions/mortages')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('transactions/mortages'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Gadai Cicilan</span>
											</a>
										</li>
									<?php endif;?>

									<?php if(read_access('transactions/bookcash')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('transactions/bookcash'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">BAP kas</span>
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

									<?php if(read_access('report/regularpawns')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/regularpawns'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Gadai Reguler</span>
											</a>
										</li>
									<?php endif;?>

									<?php if(read_access('report/mortages')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/mortages'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Gadai Cicilan</span>
											</a>
										</li>
									<?php endif;?>

									<?php if(read_access('report/modalkerja')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/modalkerja'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Modal Kerja</span>
											</a>
										</li>
									<?php endif;?>									

									<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
										<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
											<span class="kt-menu__link-text">Jurnal</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
										</a>
										<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
											<ul class="kt-menu__subnav">											
												<?php if(read_access('report/pendapatan')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/pendapatan'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Pendapatan</span>
														</a>
													</li>
												<?php endif;?>												
												<?php if(read_access('report/pengeluaran')):?>
													<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
															<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
														<span class="kt-menu__link-icon">
														<i class="fa fa-copy"><span></span></i>
														</span>
																<span class="kt-menu__link-text">Pengeluaran</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
															</a>
															<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
																<ul class="kt-menu__subnav">											
																	<?php if(read_access('report/pengeluaran')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pengeluaran'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Daily</span>
																			</a>
																		</li>
																	<?php endif;?>												
																	<?php if(read_access('report/pengeluaran')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pengeluaran/weekly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Weekly</span>
																			</a>
																		</li>
																	<?php endif;?>
																	<?php if(read_access('report/pengeluaran')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pengeluaran/monthly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Monthly</span>
																			</a>
																		</li>
																	<?php endif;?>																	
																</ul>
															</div>
														</li>
												<?php endif;?>
												<?php if(read_access('report/pengeluaran')):?>
													<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
															<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
														<span class="kt-menu__link-icon">
														<i class="fa fa-copy"><span></span></i>
														</span>
																<span class="kt-menu__link-text">Pencairan</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
															</a>
															<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
																<ul class="kt-menu__subnav">											
																	<?php if(read_access('report/pencairan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pencairan'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Daily</span>
																			</a>
																		</li>
																	<?php endif;?>												
																	<?php if(read_access('report/pencairan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pencairan/weekly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Weekly</span>
																			</a>
																		</li>
																	<?php endif;?>
																	<?php if(read_access('report/pencairan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pencairan/monthly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Monthly</span>
																			</a>
																		</li>
																	<?php endif;?>																	
																</ul>
															</div>
														</li>
												<?php endif;?>
												<?php if(read_access('report/pengeluaran')):?>
													<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
															<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
														<span class="kt-menu__link-icon">
														<i class="fa fa-copy"><span></span></i>
														</span>
																<span class="kt-menu__link-text">Pelunasan</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
															</a>
															<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
																<ul class="kt-menu__subnav">											
																	<?php if(read_access('report/pelunasan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pelunasan'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Daily</span>
																			</a>
																		</li>
																	<?php endif;?>												
																	<?php if(read_access('report/pelunasan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pelunasan/weekly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Weekly</span>
																			</a>
																		</li>
																	<?php endif;?>
																	<?php if(read_access('report/pelunasan')):?>
																		<li class="kt-menu__item "  aria-haspopup="true">
																			<a  href="<?php echo base_url('report/pelunasan/monthly'); ?>" class="kt-menu__link ">
																				<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
																				<span class="kt-menu__link-text">Monthly</span>
																			</a>
																		</li>
																	<?php endif;?>																	
																</ul>
															</div>
														</li>
												<?php endif;?>
												<?php if(read_access('report/bukukas')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/bukukas'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Buku kas</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/bukubank')):?>
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
									<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
										<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
											<span class="kt-menu__link-text">Executive Summary</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
										</a>
										<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
											<ul class="kt-menu__subnav">											
												<?php if(read_access('report/outstanding')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/outstanding'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Outstanding</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/booking')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/booking'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Booking</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/dpd')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/dpd'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">DPD</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/pencairan')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/pencairan'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Pencairan</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/pelunasan')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/pelunasan'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Pelunasan</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/pelunasan')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/summaryrate'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Rate</span>
														</a>
													</li>
												<?php endif;?>		
												<?php if(read_access('report/saldokas')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/saldokas'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Saldo Kas</span>
														</a>
													</li>
												<?php endif;?>
											</ul>
										</div>
									</li>

									<?php if(read_access('report/bapkas')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/bapkas'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">BAP Kas</span>
											</a>
										</li>
									<?php endif;?>									
									<?php if(read_access('report/typerate')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/typerate'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Units Type Rate</span>
											</a>
										</li>
									<?php endif;?>					
										
									<?php if(read_access('report/coc')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/coc'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">COC</span>
											</a>
										</li>
									<?php endif;?>	

									<?php if(read_access('report/customermis')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('report/customermis'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Transaksi Selisih</span>
											</a>
										</li>
									<?php endif;?>

									<li class="kt-menu__item  kt-menu__item--submenu"  data-ktmenu-submenu-toggle="hover" aria-haspopup="true">
										<a  href="javascript:;" class="kt-menu__link kt-menu__toggle">
									<span class="kt-menu__link-icon">
									<i class="fa fa-copy"><span></span></i>
									</span>
											<span class="kt-menu__link-text">Manual Check</span><i class="kt-menu__hor-arrow la la-angle-right"></i><i class="kt-menu__ver-arrow la la-angle-right"></i>
										</a>
										<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--right">
											<ul class="kt-menu__subnav">											
												<?php if(read_access('report/konversi/outstanding')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/konversi/outstanding'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Outstanding</span>
														</a>
													</li>
												<?php endif;?>
												<?php if(read_access('report/konversi/saldo')):?>
													<li class="kt-menu__item "  aria-haspopup="true">
														<a  href="<?php echo base_url('report/konversi/saldo'); ?>" class="kt-menu__link ">
															<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
															<span class="kt-menu__link-text">Saldo</span>
														</a>
													</li>
												<?php endif;?>												
											</ul>
										</div>
									</li>

								</ul>
							</div>
						</li>
					<?php endif;?>

						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
							<a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Lm</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('lm/grams'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
											<span class="kt-menu__link-text">Logam Mulya</span>
										</a>
									</li>
									<li class="kt-menu__item "  aria-haspopup="true">
										<a  href="<?php echo base_url('lm/transactions'); ?>" class="kt-menu__link ">
											<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
											<span class="kt-menu__link-text">Transaksi</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						<?php if($this->session->userdata('user')->level=='administrator'):?>
							<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
								<a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Processing Data</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
								<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
									<ul class="kt-menu__subnav">
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('api/transactions/loaninstallments/calculation'); ?>" target="_blank" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fab fa-google-play"><span></span></i></span>
												<span class="kt-menu__link-text">RUN OJK</span>
											</a>
										</li>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('api/transactions/loaninstallments/calculation?ojk=NON-OJK'); ?>" target="_blank" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fab fa-google-play"><span></span></i></span>
												<span class="kt-menu__link-text">RUN NON OJK</span>
											</a>
										</li>
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
							<?php $level = $this->session->userdata('user')->level;?>
							<?php if($level=='administrator'){ ?>
								<a  href="<?php echo base_url('dailyreport/unitsreport'); ?>" class="btn btn-primary"><i class="fa fa-envelope"></i> Upload</a>&nbsp
								<!-- <a  href="<?php //echo base_url('dailyreport/unitsreportojk'); ?>" class="btn btn-success"><i class="fa fa-check-double"></i> OJK</a>&nbsp -->
							<?php } ?>
								<a  href="#" data-toggle="modal" data-target="#ticket" class="btn btn-warning" title="Ticket Complain"><i class="fa fa-comments"></i></a>&nbsp
								<a  href="#"  data-toggle="modal" data-target="#help" class="btn btn-warning"><i class="fa fa-exclamation-circle"></i> Help</a>
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
