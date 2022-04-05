
					<?php if(read_access('datamaster')):?>
						<li class="kt-menu__item  kt-menu__item--submenu kt-menu__item--rel"  data-ktmenu-submenu-toggle="click" aria-haspopup="true">
							<a  href="javascript:;" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Data Master</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
							<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
								<ul class="kt-menu__subnav">

									<?php if(read_access('datamaster/customers')):?>
										<li class="kt-menu__item "  aria-haspopup="true">
											<a  href="<?php echo base_url('datamaster/customers'); ?>" class="kt-menu__link ">
												<span class="kt-menu__link-icon"><i class="fa fa-file"><span></span></i></span>
												<span class="kt-menu__link-text">Customers</span>
											</a>
										</li>
									<?php endif;?>
									
								</ul>
							</div>
						</li>
					<?php endif;?>