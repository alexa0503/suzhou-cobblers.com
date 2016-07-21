@extends('cms.layout')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>产品管理</h2>
                    </div>
                </div>
                <!-- Start .row -->
                <div class="row" style="min-height:800px;">
                    <div class="col-lg-12">
                        <div class="tabs mb20">
                            <ul id="myTab" class="nav nav-tabs">
                                <li class="active">
                                    <a href="#common" data-toggle="tab" aria-expanded="true">通用属性</a>
                                </li>
                                <li class="">
                                    <a href="#content-cn" data-toggle="tab" aria-expanded="false">中文</a>
                                </li>
                                <li class="">
                                    <a href="#content-en" data-toggle="tab" aria-expanded="false">英文</a>
                                </li>
                                <li class="">
                                    <a href="{{route('admin.product.edit',['id'=>$product->id])}}" aria-expanded="false"><i class="glyphicon glyphicon-pencil"></i>编辑</a>
                                </li>
                                <li class="">
                                    <a href="{{route('admin.product.index')}}" aria-expanded="false"><i class="glyphicon glyphicon-step-backward"></i>返回</a>
                                </li>
                            </ul>
                            <div id="myTabContent2" class="tab-content">
                                <div class="tab-pane fade active in" id="common">
                                    <div class="form-horizontal group-border stripped">
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">库存</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$product->stock}}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">所属分类</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static"><a title="编辑" href="{{route('admin.products.type.edit',['id'=>$product->type_id])}}">{{$product->type->title}}</a></p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">尺码标准</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static"><a href="" title="编辑">{{$product->sizeType->name}}</a></p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">产品图片</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">
                                                <div class="thumb-preview">
                                                    @foreach ($product->images as $image)
                                                    <img src="{{asset($image->image_path)}}" />
                                                    @endforeach
                                                </div>
                                            </p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">产品状态</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$product->status_title}}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">创建时间</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$product->created_at}}</p>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade" id="content-cn">
                                    <div class="form-horizontal group-border stripped">
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">产品名称</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$properties['zh-cn']['title']}}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">产品价格</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$prices['zh-cn']['symbol']}}{{$prices['zh-cn']['value']}}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">产品描述</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{!!$properties['zh-cn']['desc']!!}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">退换说明</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$properties['zh-cn']['return_desc']}}</p>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="" class="col-lg-2 col-md-3 control-label">清洁指南</label>
                                        <div class="col-lg-10 col-md-9">
                                            <p class="form-control-static">{{$properties['zh-cn']['clean_desc']}}</p>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade" id="content-en">
                                    @if (isset($prices['en']) AND isset($properties['en']))
                                    <div class="form-horizontal group-border stripped">
                                        <div class="form-group">
                                          <label for="" class="col-lg-2 col-md-3 control-label">产品名称</label>
                                          <div class="col-lg-10 col-md-9">
                                              <p class="form-control-static">{{$properties['en']['title']}}</p>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="" class="col-lg-2 col-md-3 control-label">产品价格</label>
                                          <div class="col-lg-10 col-md-9">
                                              <p class="form-control-static">{{$prices['en']['symbol']}}{{$prices['en']['value']}}</p>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="" class="col-lg-2 col-md-3 control-label">产品描述</label>
                                          <div class="col-lg-10 col-md-9">
                                              <p class="form-control-static">{!!$properties['en']['desc']!!}</p>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="" class="col-lg-2 col-md-3 control-label">退换说明</label>
                                          <div class="col-lg-10 col-md-9">
                                              <p class="form-control-static">{{$properties['en']['return_desc']}}</p>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                          <label for="" class="col-lg-2 col-md-3 control-label">清洁指南</label>
                                          <div class="col-lg-10 col-md-9">
                                              <p class="form-control-static">{{$properties['en']['clean_desc']}}</p>
                                          </div>
                                        </div>
                                  </div>
                                  @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
@endsection
