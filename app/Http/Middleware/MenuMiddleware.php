<?php

namespace App\Http\Middleware;

use Closure;
use Menu;
use App;
class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::make('homeNavbar', function($menu){
            $menu->add(trans('messages.menu.home'),['route'=>'home']);
            $products = $menu->add(trans('messages.menu.products'),'#');
            $products->add(trans('messages.new_items'),route('new'));
            $product_types = App\ProductType::all();
            foreach( $product_types as $type){
                $products->add($type->title, route('product.index',['type'=>$type->id ]));
            }
            $menu->add(trans('messages.menu.about_us'), ['route'=>'page.about']);
            $menu->add(trans('messages.menu.hand_made'), ['route'=>'page.hand']);
            $menu->add(trans('messages.menu.press'), ['route'=>'presses']);
            $menu->add(trans('messages.menu.wholesale'), ['route'=>'page.wholesale']);
            $menu->add(trans('messages.menu.contact_us'), ['route'=>'page.contact']);
        });
        Menu::make('adminNavbar', function($menu){
            $menu->add('控制面板',['route'=>'admin_dashboard'])->divide();

            $order_item = $menu->add('订单管理', '#')->divide();
            $order_item->add('待发货订单', route('admin.order.index',['status'=>1]));
            $order_item->add('待完成订单', route('admin.order.index',['status'=>2]));
            $order_item->add('查看所有', route('admin.order.index'));

            $product_type_item = $menu->add('产品分类', '#');
            $product_type_item->add('查看', route('admin.products.type.index'));
            $product_type_item->add('添加', route('admin.products.type.create'));

            $product_item = $menu->add('产品管理', '#')->divide();
            $product_item->add('查看', route('admin.product.index'));
            $product_item->add('添加', route('admin.product.create'));

            $fee_item = $menu->add('运费管理', '#');
            $fee_item->add('查看', route('admin.deliver.fee.index'));
            $fee_item->add('添加', route('admin.deliver.fee.create'));
            $deliver_item = $menu->add('快递方式', '#');
            $deliver_item->add('查看', route('admin.deliver.type.index'));
            $deliver_item->add('添加', route('admin.deliver.type.create'));
            $menu->add('城市管理', route('admin.city'))->divide();

            $page_item = $menu->add('页面管理', '#');
            $pages = App\Page::all();
            $pages->each(function($page,$key) use($page_item){
                $page_item->add($page->title, ['url'=>route('admin.page.edit',['id'=>$page->id])]);
            });

            $press_item = $menu->add('媒体管理', '#');
            $press_item->add('查看', route('admin.press.index'));
            $press_item->add('添加', route('admin.press.create'));

            //$page->add('查看', 'page/view');
            //$menu->add('账户',['route'=>'admin_account']);
        });
        return $next($request);
    }
}
