{{--<div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-light m-aside-menu--submenu-skin-light noPrint" data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">--}}
{{--    @if(session()->get('isadmin'))--}}
{{--        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">--}}
{{--                        menu admin--}}
{{--                    </span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/su/listaempresasnovas" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">Lista de empresas novas</span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/su/logs/access" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">Lista de acessos</span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/su/listaestagios" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">Lista de estágios submetidos</span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/su/listaestagiosd" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">Lista de estágios submetidos com detalhe</span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/su/stats" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">Estatísticas</span>--}}
{{--                    --}}{{--<span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a  href="#" class="m-menu__link m-menu__toggle">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-text">Consultas</span>--}}
{{--                    <i class="m-menu__ver-arrow la la-angle-right"></i>--}}
{{--                </a>--}}
{{--                <div class="m-menu__submenu ">--}}
{{--                    <span class="m-menu__arrow"></span>--}}
{{--                    <ul class="m-menu__subnav">--}}
{{--                        @php--}}
{{--                            /*if($_SERVER['REMOTE_ADDR'] =='176.79.91.117' || true) {*/--}}
{{--                            if(true) {--}}
{{--                        @endphp--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/empresascomestagiosano/2022" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-stopwatch"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Empresas com estágios em 2022</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/su/candidatos" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-stopwatch"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Candidatos</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        @php--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        --}}{{--<li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/dashboard" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-line-graph"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Dashboard</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/files" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-tool-1"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Relatórios</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/lastinserted" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-stopwatch"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Últimos inseridos</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/dashboard" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-line-graph"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Dashboard--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/users/list" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-users"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Administradores--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/docentes/lista" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-user"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Docentes--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/empresas/lista" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-analytics"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Empresas--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/empresas/lista-2" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-analytics"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Empresas 2--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a  href="#" class="m-menu__link m-menu__toggle">--}}
{{--                    <i class="m-menu__link-icon flaticon-signs-2"></i>--}}
{{--                    <span class="m-menu__link-text">--}}
{{--										Estágios--}}
{{--									</span>--}}
{{--                    <i class="m-menu__ver-arrow la la-angle-right"></i>--}}
{{--                </a>--}}
{{--                <div class="m-menu__submenu ">--}}
{{--                    <span class="m-menu__arrow"></span>--}}
{{--                    <ul class="m-menu__subnav">--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/estagios/lista" class="m-menu__link ">--}}
{{--                                <!--i class="m-menu__link-icon flaticon-clock-1"></i-->--}}
{{--                                <i class="m-menu__link-icon flaticon-list-2"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">--}}
{{--													Lista de estágios--}}
{{--												</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/estagios/propostas/lista" class="m-menu__link ">--}}
{{--                                <!--i class="m-menu__link-icon flaticon-clock-1"></i-->--}}
{{--                                <i class="m-menu__link-icon flaticon-list-2"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">--}}
{{--													Lista de estágios com filtros--}}
{{--												</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/estagios/periodos/lista" class="m-menu__link ">--}}
{{--                                <!--i class="m-menu__link-icon flaticon-clock-1"></i-->--}}
{{--                                <i class="m-menu__link-icon flaticon-calendar"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">--}}
{{--													Períodos de estágio--}}
{{--												</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/estagios/propostas/lista" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                                <span></span>--}}
{{--                                </i>--}}
{{--                                <span class="m-menu__link-text">--}}
{{--													Propostas de estágio--}}
{{--												</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="../../../components/icons/lineawesome.html" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-layers"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">--}}
{{--													Candidaturas de alunos--}}
{{--												</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  data-menu-submenu-toggle="hover">--}}
{{--                <a  href="#" class="m-menu__link m-menu__toggle">--}}
{{--                    <i class="m-menu__link-icon flaticon-diagram"></i>--}}
{{--                    <span class="m-menu__link-text">Consultas</span>--}}
{{--                    <i class="m-menu__ver-arrow la la-angle-right"></i>--}}
{{--                </a>--}}
{{--                <div class="m-menu__submenu ">--}}
{{--                    <span class="m-menu__arrow"></span>--}}
{{--                    <ul class="m-menu__subnav">--}}
{{--                        @php--}}
{{--                            /*if($_SERVER['REMOTE_ADDR'] =='176.79.91.117' || true) {*/--}}
{{--                            if(true) {--}}
{{--                        @endphp--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/common" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-stopwatch"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Comuns</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        @php--}}
{{--                            }--}}
{{--                        @endphp--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/dashboard" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-line-graph"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Dashboard</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/files" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-tool-1"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Relatórios</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                            <a  href="/queries/lastinserted" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-icon flaticon-stopwatch"></i>--}}
{{--                                <span></span>--}}
{{--                                <span class="m-menu__link-text">Últimos inseridos</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    @endif--}}

{{--    @if(session()->get('isaluno') || session()->get('isadmin'))--}}
{{--        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                        <span class="m-menu__link-wrap">--}}
{{--                            <span class="m-menu__link-text">menu aluno</span>--}}
{{--                            <span class="m-menu__link-badge">--}}
{{--                                <span class="m-badge m-badge--danger">2</span>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/aluno/dados" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                        <span class="m-menu__link-wrap">--}}
{{--                            <span class="m-menu__link-text">Dados do aluno</span>--}}
{{--                            <!--span class="m-menu__link-badge">--}}
{{--                                <span class="m-badge m-badge--danger">2</span>--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/aluno/relatorioprogresso/novo" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                        <span class="m-menu__link-wrap">--}}
{{--                            <span class="m-menu__link-text">Novo relatório de progresso</span>--}}
{{--                            <!--span class="m-menu__link-badge">--}}
{{--                                <span class="m-badge m-badge--danger">2</span>--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/aluno/defesaintermedia/info" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                        <span class="m-menu__link-wrap">--}}
{{--                            <span class="m-menu__link-text">Defesa intermédia</span>--}}
{{--                            <!--span class="m-menu__link-badge">--}}
{{--                                <span class="m-badge m-badge--danger">2</span>--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    @endif--}}

{{--    @if(session()->get('isdocente') || session()->get('isadmin'))--}}
{{--        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                <span class="m-menu__link-wrap">--}}
{{--                    <span class="m-menu__link-text">--}}
{{--                        menu docente--}}
{{--                    </span>--}}
{{--                    <span class="m-menu__link-badge">--}}
{{--                        <span class="m-badge m-badge--danger">--}}
{{--                            2--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--            </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    @endif--}}

{{--    @if((session()->get('profile')==2 || session()->get('profile')==4) && !session()->get('isadmin'))--}}
{{--        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">--}}
{{--            --}}{{--<li class="m-menu__item " aria-haspopup="true" >--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                        <span class="m-menu__link-wrap">--}}
{{--                            <span class="m-menu__link-text">--}}
{{--                                Empresas / [{{session()->get('isadmin')}}]--}}
{{--                            </span>--}}
{{--                            <span class="m-menu__link-badge">--}}
{{--                                <span class="m-badge m-badge--danger">--}}
{{--                                    2--}}
{{--                                </span>--}}
{{--                            </span>--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/dashboard" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-line-graph"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Dashboard--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}



{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/dadosempresa" class="m-menu__link ">--}}
{{--                    <!--i class="m-menu__link-icon flaticon-clock-1"></i-->--}}
{{--                    <i class="m-menu__link-icon flaticon-list-2"></i>--}}
{{--                    <span></span>--}}
{{--                    <span class="m-menu__link-text">Dados da empresa</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a  href="/estagios/lista" class="m-menu__link ">--}}
{{--                    <i class="m-menu__link-icon flaticon-network"></i>--}}
{{--                    <span class="m-menu__link-title">--}}
{{--                    <span class="m-menu__link-wrap">--}}
{{--                        <span class="m-menu__link-text">--}}
{{--                            Propostas de estágio--}}
{{--                        </span>--}}
{{--                        <span class="m-menu__link-badge">--}}
{{--                            <!--span class="m-badge m-badge--danger">--}}
{{--                                2--}}
{{--                            </span-->--}}
{{--                        </span>--}}
{{--                    </span>--}}
{{--                </span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--            <li class="m-menu__item " aria-haspopup="true" >--}}
{{--                <a href="/estagios/propostas/nova/" class="m-menu__link">--}}
{{--                    <i class="m-menu__link-icon flaticon-layers"></i>--}}
{{--                    <span></span>--}}
{{--                    <span class="m-menu__link-text">Adicionar candidatura</span>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    @endif--}}
{{--</div>--}}

<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{env('APP_URL')}}">
            <img alt="Logo DEI" src="{{asset('logos/uc_dei_logo_inverted.png')}}" class="app-sidebar-logo-default" height="60px">
            <img alt="Logo DEI" src="{{asset('logos/uc_dei_logo_inverted_small.png')}}" class="h-20px app-sidebar-logo-minimize">
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
										<path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
									</svg>
								</span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
            <!--begin::Menu-->
            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
                @foreach($categoryNames as $category)
                    @include('metronicv815.layout.partials.leftnavcategoryitem',array('category_name' => $category))
                    @foreach($sidebaritems[$category] as $item)
                            @include('metronicv815.layout.partials.leftnavitem',array('item'=>$item))
                    @endforeach
                @endforeach
            </div>
            <!--end::Menu-->
        </div>
        <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->
    <!--begin::Footer-->
    @include('metronicv815.layout.partials.sidebarfooter')
    <!--end::Footer-->
</div>
<!--end::Sidebar-->