@extends('admin.layout')

@section('title',  __('lang.Dashboard'))

@section('content')
   <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>{{ __('lang.Dashboard') }}</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>                            
                            <li class="breadcrumb-item">{{ __('lang.App') }}</li>
                            <li class="breadcrumb-item active">{{ __('lang.Blog') }}</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="page_action">
                                <a href="{{ route('localized.admin.blog-create', ['lang' => app()->getLocale()])}}" class="btn btn-secondary" title="new post">{{ __('lang.New post') }}</a>
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix row-deck">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card top_widget">
                        <div class="body">
                            <div class="icon"><i class="fa fa-thumbs-o-up"></i> </div>
                            <div class="content">
                                <div class="text mb-2 text-uppercase">{{ __('lang.Likes') }}</div>
                                <h4 class="number mb-0">22,500 <span class="font-12 text-muted"><i class="fa fa-level-up"></i> 4%</span></h4>
                                <small class="text-muted">{{ __('lang.Analytics for last Month') }}</small>
                            </div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#73cec7" data-fill-Color="#73cec7">2,3,1,5,4,2,3,1,5,4,7,8,2,3,1,4,6,5,4,4,4,7,8,2,3,1,4,6,5,4</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card top_widget">
                        <div class="body">
                            <div class="icon"><i class="fa fa-comment"></i> </div>
                            <div class="content">
                                <div class="text mb-2 text-uppercase">{{ __('lang.Comments') }}</div>
                                <h4 class="number mb-0">500 <span class="font-12 text-muted"><i class="fa fa-level-up"></i> 11%</span></h4>
                                <small class="text-muted">{{ __('lang.Analytics for last Month') }}</small>
                            </div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#7ea7de" data-fill-Color="#7ea7de">7,8,2,3,1,4,6,2,3,1,5,4,7,8,2,3,1,4,6,5,4,4,2,3,1,5,4,5,4,4</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card top_widget">
                        <div class="body">
                            <div class="icon"><i class="fa fa-share-alt"></i> </div>
                            <div class="content">
                                <div class="text mb-2 text-uppercase">{{ __('lang.Share') }}</div>
                                <h4 class="number mb-0">2,215 <span class="font-12 text-muted"><i class="fa fa-level-up"></i> 9%</span></h4>
                                <small class="text-muted">{{ __('lang.Analytics for last Month') }}</small>
                            </div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#84d4a6" data-fill-Color="#84d4a6">2,3,1,5,4,7,8,2,3,1,4,6,5,4,4,2,3,1,5,4,7,8,2,3,1,4,6,5,4,4</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card top_widget">
                        <div class="body">
                            <div class="icon"><i class="fa fa-eye"></i> </div>
                            <div class="content">
                                <div class="text mb-2 text-uppercase">{{ __('lang.View') }}</div>
                                <h4 class="number mb-0">421,215 <span class="font-12 text-muted"><i class="fa fa-level-down"></i> 2%</span></h4>
                                <small class="text-muted">{{ __('lang.Analytics for last Month') }}</small>
                            </div>
                        </div>
                        <div class="sparkline" data-type="line" data-spot-Radius="0" data-offset="90" data-width="100%" data-height="50px"
                        data-line-Width="1" data-line-Color="#efc26b" data-fill-Color="#efc26b">2,3,1,5,4,7,8,2,3,1,4,6,5,4,4,1,5,4,7,8,2,3,1,4,6,5,4,4,2,3</div>
                    </div>
                </div>
            </div>

          
            <div class="row clearfix row-deck">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{ __('lang.Return Visitor Information') }}</h2>
                            <ul class="header-dropdown">
                                <li><a href="#" title=""><i class="fa fa-envelope"></i></a></li>
                                <li><a href="#" title=""><i class="fa fa-download"></i></a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">{{ __('lang.Action') }}</a></li>
                                        <li><a href="javascript:void(0);">{{ __('lang.Another Action') }}</a></li>
                                        <li><a href="javascript:void(0);">{{ __('lang.Something else') }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="Return-Visitor-Information"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{ __('lang.Bounce Rate') }}</h2>
                            <ul class="header-dropdown">
                                <li><a href="#" title=""><i class="fa fa-envelope"></i></a></li>
                                <li><a href="#" title=""><i class="fa fa-download"></i></a></li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="javascript:void(0);">{{ __('lang.Action') }}</a></li>
                                        <li><a href="javascript:void(0);">{{ __('lang.Another Action') }}</a></li>
                                        <li><a href="javascript:void(0);">{{ __('lang.Something else') }}</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="Bounce-Rate"></div>
                        </div>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
@endsection
