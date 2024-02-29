
<div id="mySidebar" class="sidebar block sm:block sm:w-20 w-0" onmouseover="toggleSidebar(true)" onmouseout="toggleSidebar(false)">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset pb-0">
                <!-- Content -->
                <div class="navbar-vertical-content" style="background-color:black;">

                    <ul class="navbar-nav" dir="{{Session::get('direction')}}" style="{{(Session::get('direction') ?? 'rtl') === "rtl" ? 'padding-right: 0px' : ''}}">
                        @php($storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id())
                        @php($user = \App\User::find($storeId))
                        @if($user->is_active)
                        @if (\App\CPU\Helpers::store_module_permission_check('store.home.view'))
                        <a href="{{route('home')}}" class="{{ (Route::is('home')) ? ' active bg-black sm:bg-white ' : '' }}">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="ri-home-5-fill"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('Home') }}</span>
                            </span>
                        </a><br />
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.products.view'))
                        <a href="{{route('products',['data_from' => 'latest'])}}" class="{{ (Route::is('products')) ? ' active bg-black sm:bg-white ' : '' }}">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="ri-box-3-fill"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('products') }}</span>
                            </span>
                        </a><br />
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('My_Shop.products.pending.view') || \App\CPU\Helpers::store_module_permission_check('My_Shop.products.sync.view') || \App\CPU\Helpers::store_module_permission_check('My_Shop.products.deleted.view'))
                        <a href="{{route('linked-products-get')}}" class="{{ (Route::is('linked-products*')) ? ' active bg-black sm:bg-white ' : '' }}">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="fa fa-store"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('List of my products synced with my store')}}</span>
                            </span>
                        </a><br />
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.sellers.view'))
                        @php($business_mode=\App\CPU\Helpers::get_business_settings('business_mode'))
                        @if ($business_mode == 'multi' && (\App\Model\BusinessSetting::where('type','show_sellers_section')->first()->value ?? ''))
                        <a href="{{route('sellers')}}" class="{{ (Route::is('sellers')) ? ' active bg-black sm:bg-white ' : '' }}">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="fa fa-users"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('Sellers')}}</span>
                            </span>
                        </a><br />
                        @endif
                        @endif

                        @if (\App\CPU\Helpers::store_module_permission_check('order.sync.view') || \App\CPU\Helpers::store_module_permission_check('order.direct.view'))
                        <a href="{{route('orders')}}" class="{{ (Route::is('orders')) ? ' active bg-black sm:bg-white ' : '' }}">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="czi-basket"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('Orders')}}</span>
                            </span>
                        </a><br />
                        @endif

                        @endif
                        @if(\App\CPU\Helpers::store_module_permission_check('my_account.data.view') || \App\CPU\Helpers::store_module_permission_check('my_account.employees.view') || \App\CPU\Helpers::store_module_permission_check('my_account.my_wallet.view') || \App\CPU\Helpers::store_module_permission_check('my_account.my_loyalty_point.view') || \App\CPU\Helpers::store_module_permission_check('my_account.wish_list.view') || \App\CPU\Helpers::store_module_permission_check('my_account.support_ticket.view') || \App\CPU\Helpers::store_module_permission_check('my_account.chat_with_seller.view') || \App\CPU\Helpers::store_module_permission_check('my_account.chat_with_delivery_man.view') || \App\CPU\Helpers::store_module_permission_check('my_account.linking_store_API.view') || \App\CPU\Helpers::store_module_permission_check('my_account.subscriptions.view'))
                        <a href="#" class="{{ (Route::is('user-account')) ? ' active bg-black sm:bg-white ' : '' }}" onclick="toggleHelpCenterLinkStyle(); $('#user-settings-menu').slideToggle()">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="fa fa-user"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('my account settings') }}</span>
                            </span>
                        </a><br />
                        <ul id="user-settings-menu" class="ms-5" style="display: {{ (Route::is('user-account')) ? 'block' : 'none' }}">
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.data.view'))
                            <li>
                                <a class="{{Request::is('user-account*')?'active-menu':''}} pt-0 mt-0"
                                    href="{{route('user-account')}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('my account data') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.employees.view'))
                            <li>
                                <a class="{{Request::is('delegates*')?'active-menu':''}}"
                                    href="{{route('delegates.list')}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('Employees') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            {{--  @if (\App\CPU\Helpers::store_module_permission_check('my_account.my_wallet.view'))
                            <li>
                                <a class="{{Request::is('wallet*') ? 'active-menu' :''}}"
                                    href="{{route('wallet') }} ">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('my_wallet') }}
                                    </span>
                                </a>
                            </li>
                            @endif  --}}
                            @if (Helpers::get_business_settings('loyalty_point_status') && Helpers::store_module_permission_check('my_account.my_loyalty_point.view'))
                            <li>
                                <a class="{{Request::is('wallet*') ? 'active-menu' :''}}"
                                    href="{{route('loyalty') }} ">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('my_loyalty_point') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            {{--  @if (\App\CPU\Helpers::store_module_permission_check('my_account.wish_list.view'))
                            <li>
                                <a class="{{Request::is('wishlists*') ? 'active-menu' :''}}"
                                    href="{{route('wishlists') }} ">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('wish_list') }}
                                    </span>
                                </a>
                            </li>
                            @endif  --}}
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.support_ticket.view'))
                            <li>
                                <a class="{{Request::is('account-tickets*') ? 'active-menu' :''}}"
                                    href="{{route('account-tickets') }} ">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('support_ticket') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.chat_with_seller.view'))
                            @if(Helpers::get_business_settings('chat_with_seller_status'))
                            <li>
                                <a class="{{Request::is('chat/seller*') ? 'active-menu' :''}}"
                                    href="{{route('chat',['type'=>'seller'])}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('chat_with_seller') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.chat_with_delivery_man.view'))
                            @if(Helpers::get_business_settings('chat_with_delivery_status'))
                            <li>
                                <a class="{{Request::is('/chat/delivery-man*') ? 'active-menu' :''}}"
                                    href="{{route('chat',['type'=>'delivery-man'])}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('chat_with_delivery-man') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.linking_store_API.view'))
                            <li>
                                <a class="{{Request::is('linked-accounts') ? 'active-menu' :''}}"
                                    href="{{route('linked-accounts')}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('Settings for linking my online store API') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                            @if (\App\CPU\Helpers::store_module_permission_check('my_account.subscriptions.view'))
                            <li>
                                <a class="{{Request::is('linked-accounts') ? 'active-menu' :''}}" href="{{route('subscriptions')}}">
                                    <span style="font-size: 16px">
                                        {{ \App\CPU\Helpers::translate('Subscriptions') }}
                                    </span>
                                </a>
                            </li>
                            @endif
                        </ul>
                        @endif
                        @if (\App\CPU\Helpers::store_module_permission_check('store.home.show_education'))
                        <a href="{{route('education.home')}}" class="{{ (Route::is('education')) ? ' active bg-black sm:bg-white ' : '' }}" id="helpCenterLink" style="bottom: 30px;position: absolute;">
                            <span>
                                <i style="min-width: 50px;display:inline-block" class="fa fa-question"></i>
                                <span class="icon-text">{{ \App\CPU\Helpers::translate('Help Center') }}</span>
                            </span>
                        </a>

                    </ul>
                    @endif
                </div>
                <!-- End Content -->
            </div>
        </div>
</div>

@push('script')
    <script>
        function HSDemo() {

            var settings = {
              //headerMain: document.getElementById("headerMain").innerHTML,
              //headerFluid: document.getElementById("headerFluid").innerHTML,
              //headerDouble: document.getElementById("headerDouble").innerHTML,
              //sidebarMain: document.getElementById("sidebarMain").innerHTML,
            }

            // Layouts
            var body = document.getElementsByTagName('body')[0],
              header = document.getElementsByClassName('navbar')[0],
              navbarVerticalAside = document.getElementsByClassName('navbar-vertical-aside')[0]; // Radios

            var radiosSkin = Array.prototype.slice.call(document.querySelectorAll('input[type=radio][name="layoutSkinsRadio"]'), 0),
              radiosSidebarMode = Array.prototype.slice.call(document.querySelectorAll('input[type=radio][name="sidebarLayoutOptions"]'), 0),
              radiosHeaderMode = Array.prototype.slice.call(document.querySelectorAll('input[type=radio][name="headerLayoutOptions"]'), 0); // Local Storage

            var skin = window.localStorage.getItem('hs-builder-skin') === null ? 'default' : window.localStorage.getItem('hs-builder-skin'),
              sidebarMode = window.localStorage.getItem('hs-builder-sidebar-mode') === null ? 'default' : window.localStorage.getItem('hs-builder-sidebar-mode'),
              headerMode = window.localStorage.getItem('hs-builder-header-mode') === null ? 'false' : window.localStorage.getItem('hs-builder-header-mode');

            var appendLayout = function appendLayout(str) {
                if(typeof str !== 'undefined' && str){
                    body.insertAdjacentHTML('afterbegin', str);
                }
            };

            function addContainer() {
              var style = document.createElement('style');
              document.head.appendChild(style);
              style.textContent = "         \n      .content,\n      .footer {\n        width: 100%;\n        padding-right: 15px !important;\n        padding-left: 15px !important;\n        margin-right: auto;\n        margin-left: auto;\n      }\n      \n      @media (min-width: 1400px) {\n        .content,\n        .footer {\n          max-width: 1320px;\n        }\n      }       \n      \n      @media (min-width: 1400px) {\n        .content,\n        .footer {\n          max-width: 1320px;\n        }\n      }\n    ";
            }

            if (sidebarMode !== false || headerMode !== false) {
              body.classList.remove('navbar-vertical-aside-mini-mode');
            }

            if (headerMode == 'false') {
              if (!sidebarMode || sidebarMode === 'default') {
                if(typeof settings.sidebarMain !== 'undefined' && settings.sidebarMain){
                    appendLayout(settings.sidebarMain);
                }
              } else if (sidebarMode === 'navbar-vertical-aside-compact-mode') {
                appendLayout(settings.sidebarCompact);
                document.body.className += ' navbar-vertical-aside-compact-mode navbar-vertical-aside-compact-mini-mode';
                var style = document.createElement('style');
                document.head.appendChild(style);
                style.textContent = "\n@media(min-width: 993px) {\n.js-navbar-vertical-aside-toggle-invoker {\ndisplay: none !important;\n}\n}\n";
              } else if (sidebarMode === 'navbar-vertical-aside-mini-mode') {
                appendLayout(settings.sidebarMain);
                document.body.className += ' navbar-vertical-aside-mini-mode';
              }

              document.body.className += ' footer-offset has-navbar-vertical-aside navbar-vertical-aside-show-xl';
            }

            if (headerMode === 'single') {
              if (skin === 'navbar-dark') {
                settings.headerFluid = settings.headerFluid.replace(/btn-ghost-secondary/g, 'btn-ghost-light');
              }



              appendLayout(settings.headerFluid);
              body.classList.add('footer-offset');
              var _header = document.getElementsByClassName('navbar')[0],
                oldHeaderContent = _header.innerHTML;
              _header.innerHTML = '<div class="container">' + oldHeaderContent + '</div>';
              addContainer();
            } else if (headerMode === 'double') {
              appendLayout(settings.headerDouble);
              body.classList.add('footer-offset');

              if ('scrollRestoration' in history) {
                // Back off, browser, I got this...
                history.scrollRestoration = 'manual';
              }
            } else if (headerMode === 'double-container') {
              appendLayout(settings.headerDouble);
              body.classList.add('footer-offset');
              var _header2 = document.getElementsByClassName('navbar')[0],
                fisrtElement = _header2.firstElementChild;
              fisrtElement.innerHTML = '<div class="navbar-dark w-full"> <div class="container">' + fisrtElement.firstElementChild.innerHTML + '</div> </div>';
              _header2.innerHTML = fisrtElement.innerHTML + ' <div class="container">' + _header2.lastElementChild.innerHTML + '</div>';
              addContainer();

              if ('scrollRestoration' in history) {
                // Back off, browser, I got this...
                history.scrollRestoration = 'manual';
              }
            } else {
              appendLayout(settings.headerMain);
            }

            if (skin && headerMode !== 'double' && headerMode !== 'double-container') {
              var _header3 = document.getElementsByClassName('navbar')[0],
                sidebar = document.getElementsByClassName('navbar-vertical-aside')[0];

              if (headerMode === 'single' || headerMode === 'single-container') {
                _header3.classList.add(skin);
              }

              if (sidebar) {
                sidebar.classList.add(skin);
              }

              if (skin === 'navbar-light') {
                if (_header3) {
                  _header3.classList.remove('navbar-bordered');
                }

                if (sidebar) {
                  sidebar.classList.remove('navbar-bordered');
                }
              } else if (skin === 'navbar-dark') {
                if (sidebar) {
                  for (var i = 0; i < document.querySelectorAll('aside .navbar-brand-logo').length; i++) {
                    document.querySelectorAll('aside .navbar-brand-logo')[i].setAttribute('src', document.querySelectorAll('aside .navbar-brand-logo')[0].getAttribute('src').replace('logo.svg', 'logo-white.svg'));
                  }
                } else {
                  for (var i = 0; i < document.querySelectorAll('header .navbar-brand-logo').length; i++) {
                    document.querySelectorAll('header .navbar-brand-logo')[i].setAttribute('src', document.querySelectorAll('header .navbar-brand-logo')[0].getAttribute('src').replace('logo.svg', 'logo-white.svg'));
                  }
                }

                for (var i = 0; i < document.getElementsByClassName('navbar-brand-logo-mini').length; i++) {
                  document.getElementsByClassName('navbar-brand-logo-mini')[i].setAttribute('src', document.getElementsByClassName('navbar-brand-logo-mini')[0].getAttribute('src').replace('logo-short.svg', 'logo-short-white.svg'));
                }

                for (var i = 0; i < document.getElementsByClassName('navbar-brand-logo-short').length; i++) {
                  document.getElementsByClassName('navbar-brand-logo-short')[i].setAttribute('src', document.getElementsByClassName('navbar-brand-logo-short')[0].getAttribute('src').replace('logo-short.svg', 'logo-short-white.svg'));
                }
              }
            }

            radiosSkin.forEach(function (radio) {
              if (skin === radio.value) {
                radio.checked = true;
              }

              radio.addEventListener('change', function () {
                skin = radio.value;
              });
            });
            radiosSidebarMode.forEach(function (radio) {
              if (sidebarMode === radio.value) {
                radio.checked = true;
              }

              radio.addEventListener('change', function () {
                sidebarMode = radio.value;
                radiosSkin.forEach(function (radio) {
                  if (skin === radio.value) {
                    radio.checked = true;
                  }

                  radio.disabled = false;
                });
                radiosHeaderMode.forEach(function (radio) {
                  radio.checked = false;
                  headerMode = false;
                });
              });
            });
            radiosHeaderMode.forEach(function (radio) {
              if (headerMode === radio.value) {
                radio.checked = true;

                if (radio.value === 'double' || radio.value === 'double-container') {
                  radiosSkin.forEach(function (radio) {
                    radio.checked = false;
                    radio.disabled = true;
                  });
                  document.getElementById('js-builder-disabled').style.opacity = 1;
                }

                radiosSidebarMode.forEach(function (radio) {
                  radio.checked = false;
                });
              }

              radio.addEventListener('change', function (e) {
                if (radio.value !== 'default') {
                  headerMode = radio.value;
                } else {
                  headerMode = false;
                }

                if (e.target.value === 'double' || radio.value === 'double-container') {
                  radiosSkin.forEach(function (radio) {
                    radio.checked = false;
                    radio.disabled = true;
                  });
                } else {
                  radiosSkin.forEach(function (radio) {
                    if (skin === false && radio.value === 'default' || skin === radio.value) {
                      radio.checked = true;
                    }

                    radio.disabled = false;
                  });
                }

                radiosSidebarMode.forEach(function (radio) {
                  radio.checked = false;
                  sidebarMode = false;
                });
              });
            });
            Array.prototype.slice.call(document.querySelectorAll('.custom-checkbox-card-input'), 0).forEach(function (radio) {
              radio.addEventListener('change', function () {
                radiosSkin.forEach(function (radio) {
                  if (radio.disabled) {
                    document.getElementById('js-builder-disabled').style.opacity = 1;
                  } else {
                    document.getElementById('js-builder-disabled').style.opacity = 0;
                  }
                });
              });
            });

            //document.getElementById("headerMain").parentNode.removeChild(document.getElementById("headerMain"));
            //document.getElementById("headerFluid").parentNode.removeChild(document.getElementById("headerFluid"));
            //document.getElementById("headerDouble").parentNode.removeChild(document.getElementById("headerDouble"));
            //document.getElementById("sidebarMain").parentNode.removeChild(document.getElementById("sidebarMain"));
          }

          HSDemo();


          function formUrlChange(t){
              let action = $(t).data('action');
              $('#form-data').attr('action', action);
          }
    </script>
    <script>
        $(window).on('load' , function() {
            if($(".navbar-vertical-content li.active").length) {
                $('.navbar-vertical-content').animate({
                    scrollTop: $(".navbar-vertical-content li.active").offset().top - 150
                }, 10);
            }
        });

        //Sidebar Menu Search
        var $rows = $('.navbar-vertical-content li');
        $('#search-bar-input').keyup(function() {
            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                return !~text.indexOf(val);
            }).hide();
        });
    </script>
    <script>
        function toggleHelpCenterLinkStyle() {
            var $helpCenterLink = $('#helpCenterLink');
            var isMenuOpen = $('#user-settings-menu').is(':visible');
            if (isMenuOpen) {
                // إذا كانت القائمة مفتوحة، إزالة الستايل
                $helpCenterLink.attr('style', 'bottom: 30px; position: absolute;');
            } else {
                $helpCenterLink.removeAttr('style');
                // إذا كانت القائمة مغلقة، إعادة تطبيق الستايل

            }
        }
        </script>


@endpush


