<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \shop\orderItem
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class orderItemService extends \f\service
{

    /**
     *
     * @var shortcutMapper
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.orderItem' ) ;
    }

    public function orderItemList ()
    {
        return \f\ttt::dal ( 'shop.orderItem.orderItemList',
                             $this->request->getAssocParams () ) ;
    }

    public function orderItemSave ()
    {
        $params = $this->request->getAssocParams () ;

        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.orderItem.orderItemSaveEdit', $params ) ;
            //$msg    = \f\ifm::t ( 'orderItemSaveEdit' ) ;
        }
        else
        {
            $checkStock = \f\ttt::service ( 'shop.product.checkStockByPriceId',
                                            $params ) ;
            //check if time amazing then price- amazing else - discount
            if ( ! $params[ 'amazing_id' ] )
            {
                $end_price = $checkStock[ 'price' ] - $checkStock[ 'discount' ] ;
            }
            else
            {
                $end_price = $checkStock[ 'price' ] - $checkStock[ 'amazing_price' ] ;
            }
            //calculate amazing time price off after correction amazing backend...
            if ( $checkStock != NULL )
            {
                //check orderItems old which into cart
                $result = \f\ttt::dal ( 'shop.orderItem.checkOrderItemsOldPriceId',
                                        array (
                            'priceId' => $checkStock[ 'id' ],
                            'userId'  => $params[ 'user_id' ]
                        ) ) ;
                if ( is_array ( $result ) != NULL )
                {
                    //add count to old orderItem into cart
                    \f\ttt::dal ( 'shop.orderItem.addOrderItemCountAndMulPrice',
                                  array (
                        'id'        => $result[ 'id' ],
                        'count'     => $result[ 'count' ],
                        'end_price' => $end_price,
                        'countPlus' => '1',
                    ) ) ;
                }
                else
                {
                    //new orderItem
                    $params = array (
                        'product_price_id' => $checkStock[ 'id' ],
                        'user_id'          => $params[ 'user_id' ],
                        'date_register'    => time (),
                        'amazing_id'       => $params[ 'amazing_id' ],
                        'discount_id'      => $params[ 'discount_id' ],
                        'end_price'        => $checkStock[ 'price' ] - $checkStock[ 'discount' ],
                        'status'           => 'disabled'
                            ) ;

                    $result = \f\ttt::dal ( 'shop.orderItem.orderItemSave',
                                            $params ) ;
                }
                if ( $result )
                {
                    //stock --
                    /*
                    \f\ttt::service ( 'shop.product.minesPlusProductStock',
                                      array (
                        'id'          => $checkStock[ 'id' ],
                        'changeModel' => '-',
                        'count'       => '1'
                    ) ) ;
                     * 
                     */
                }
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => 'notStock' ) ;
            }
        }



//        if ( $result )
//        {
//            $data = array (
//                'result' => 'success',
//                    //'message' => $msg,
//                    ) ;
//        }
//        else
//        {
//            $data = array (
//                'result'  => 'error',
//                'message' => \f\ifm::t ( 'dbError' ) ) ;
//        }



        return $data ;
    }

    public function orderItemDelete ()
    {
        $params = $this->request->getAssocParams () ;

        $orderItem = \f\ttt::dal ( 'shop.orderItem.getOrderItemById',
                                   array (
                    'id' => $params[ 'orderItem_id' ]
                ) ) ;

        $order     = \f\ttt::service ( 'shop.order.getOrderById',
                                       array (
                    'id' => $params[ 'order_id' ]
                ) ) ;

        $diffPrice    = $order[ 'price' ] - ($orderItem[ 'price' ] * $orderItem[ 'count' ]) ;
        $diffDiscount = $order[ 'discount' ] - ($orderItem[ 'discount_price' ] * $orderItem[ 'count' ]) ;

        \f\ttt::dal ( 'shop.order.orderSaveEdit',
                      array (
            'id'       => $params[ 'order_id' ],
            'price'    => $diffPrice,
            'discount' => $diffDiscount,
        ) ) ;

        $orderItemGift = \f\ttt::dal ( 'shop.orderItem.getOrderItemGiftById',
            array (
                'id' => $params[ 'order_id' ]
            ) ) ;
        //\f\pr($orderItemGift);
        \f\ttt::dal ( 'shop.orderItem.orderGiftUpdate',
            array (
                'id'       => $params[ 'order_id' ],
                'orderItemGift'=>$orderItemGift
            ) ) ;

        $deleteItem=\f\ttt::dal ( 'shop.orderItem.orderItemDelete',
            array (
                'id' => $params[ 'orderItem_id' ]
            ) ) ;
        return  $deleteItem;
    }

    public function orderItemStatus ()
    {
        return \f\ttt::dal ( 'shop.orderItem.orderItemStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getOrderItemById ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getOrderItemById',
                             $this->request->getAssocParams () ) ;
    }

    public function getOrderItemByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getOrderItemByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getPriceByOrderItemById ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getPriceByOrderItemById',
                             $this->request->getAssocParams () ) ;
    }

    public function orderItemSpecial ()
    {
        return \f\ttt::dal ( 'shop.orderItem.orderItemSpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getOrderItemsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getOrderItemsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getOrderItemByParams ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getOrderItemByParams',
                             $this->request->getAssocParams () ) ;
    }
    public function getOrderItemByParamsCartSidebar ()
    {

        return \f\ttt::dal ( 'shop.orderItem.getOrderItemByParamsCartSidebar',
            $this->request->getAssocParams () ) ;
    }
    public function getOrderItemByParamsCart()
    {

        return \f\ttt::dal ( 'shop.orderItem.getOrderItemByParamsCart',
            $this->request->getAssocParams () ) ;
    }
    public function getReturnedProOfOrderItemByParams ()
    {
        return \f\ttt::dal ( 'shop.orderItem.getReturnedProOfOrderItemByParams',
            $this->request->getAssocParams () ) ;
    }

    public function addOrderItemCountAndMulPrice ()
    {
        return \f\ttt::dal ( 'shop.orderItem.addOrderItemCountAndMulPrice',
                             $this->request->getAssocParams () ) ;
    }

    public function countOrdersUnpayd ()
    {
        return \f\ttt::dal ( 'shop.orderItem.countOrdersUnpayd',
                             $this->request->getAssocParams () ) ;
    }
    
    public function updateOrderItemPrice()
    {
        return \f\ttt::dal ( 'shop.orderItem.updateOrderItemPrice',
                             $this->request->getAssocParams () ) ;
    }
    public function orderItemGiftSave (){
        return \f\ttt::dal ( 'shop.orderItem.orderItemGiftSave',
            $this->request->getAssocParams () ) ;
    }

}
