<?php

namespace SYG\Iconic\Tests\Unit;

use SYG\Iconic\ApiClient;
use Orchestra\Testbench\TestCase;
use SYG\Iconic\IconicServiceProvider;
use SYG\Iconic\Exceptions\InvalidRequestDataException;
use SYG\Iconic\Exceptions\InvalidApiCredentialsException;

class OrderRetrieverTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            IconicServiceProvider::class,
        ];
    }

    /** @test */
    public function an_order_can_be_retrieved()
    {
		$this->mock(ApiClient::class, function ($mock) {
    		$mock->shouldReceive('getData')
    				->times(2)
    				->andReturn($this->validOrderJson(), $this->validOrderItemsJson());
		});
		$orderRetriever = resolve('SYG\Iconic\OrderRetriever');
		
		$response = $orderRetriever->retrieve(8412797);

		$this->assertEquals(233634936, $response->OrderNumber);
		$this->assertCount(2, $response->OrderItems->OrderItem);
    }

    /** @test */
    public function invalid_api_credentials_throw_an_error()
    {
		$this->mock(ApiClient::class, function ($mock) {
    		$mock->shouldReceive('getData')
    				->once()
    				->andReturn($this->AccessDeniedJson());
		});
		$orderRetriever = resolve('SYG\Iconic\OrderRetriever');
		
		try {
			$orderRetriever->retrieve(8412797);
		} catch (InvalidApiCredentialsException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("Successful call was made even with invalid API credentials");
    }

    /** @test */
    public function invalid_request_data_throws_an_error()
    {
		$this->mock(ApiClient::class, function ($mock) {
    		$mock->shouldReceive('getData')
    				->once()
    				->andReturn($this->InvalidOrderIdJson());
		});
		$orderRetriever = resolve('SYG\Iconic\OrderRetriever');
		
		try {
			$orderRetriever->retrieve(1010);
		} catch (InvalidRequestDataException $e) {
			$this->assertTrue(true);
			return;
		}

		$this->fail("Successful call was made even with invalid API credentials");
    }

    private function validOrderJson()
    {
		return '{
		  "SuccessResponse": {
		    "Head": {
		      "RequestId": "",
		      "RequestAction": "GetOrder",
		      "ResponseType": "Order",
		      "Timestamp": "2019-03-27T13:42:52+1100"
		    },
		    "Body": {
		      "Orders": {
		        "Order": {
		          "OrderId": "8412797",
		          "CustomerFirstName": "Iconic",
		          "CustomerLastName": "Forevernew1",
		          "OrderNumber": "233634936",
		          "PaymentMethod": "NoPayment",
		          "Remarks": "",
		          "DeliveryInfo": "",
		          "Price": "499.90",
		          "GiftOption": "0",
		          "GiftMessage": "",
		          "VoucherCode": "",
		          "CreatedAt": "2019-03-15 09:16:36",
		          "UpdatedAt": "2019-03-26 12:59:19",
		          "AddressUpdatedAt": "2019-03-14 22:16:36",
		          "AddressBilling": {
		            "FirstName": "Iconic",
		            "LastName": "Forevernew1",
		            "Phone": "0409111222",
		            "Phone2": "",
		            "Address1": "576 Swan St",
		            "Address2": "",
		            "Address3": "",
		            "Address4": "",
		            "Address5": "",
		            "CustomerEmail": "dropshipments+test@theiconic.com.au",
		            "City": "Burnley",
		            "Ward": "",
		            "Region": "VIC",
		            "PostCode": "3121",
		            "Country": "Australia"
		          },
		          "AddressShipping": {
		            "FirstName": "Iconic",
		            "LastName": "Forevernew1",
		            "Phone": "0409111222",
		            "Phone2": "",
		            "Address1": "576 Swan St",
		            "Address2": "",
		            "Address3": "",
		            "Address4": "",
		            "Address5": "",
		            "CustomerEmail": "",
		            "City": "Burnley",
		            "Ward": "",
		            "Region": "VIC",
		            "PostCode": "3121",
		            "Country": "Australia"
		          },
		          "NationalRegistrationNumber": "",
		          "ItemsCount": "2",
		          "PromisedShippingTime": "",
		          "ExtraAttributes": "",
		          "Statuses": {
		            "Status": "shipped"
		          }
		        }
		      }
		    }
		  }
		}';   		
    }

    private function validOrderItemsJson()
    {
    	return '{
			"SuccessResponse": {
			"Head": {
			  "RequestId": "",
			  "RequestAction": "GetOrderItems",
			  "ResponseType": "OrderItems",
			  "Timestamp": "2019-03-27T14:58:36+1100"
			},
			"Body": {
			  "OrderItems": {
			    "OrderItem": [
			      {
			        "OrderItemId": "2508854",
			        "ShopId": "29016208",
			        "OrderId": "8412797",
			        "Name": "Levitate 2",
			        "Sku": "190340528026",
			        "Variation": "10",
			        "ShopSku": "BR590SH28PPN-2807524",
			        "ShippingType": "home",
			        "ItemPrice": "249.95",
			        "PaidPrice": "0.00",
			        "Currency": "AUD",
			        "WalletCredits": "249.95",
			        "TaxAmount": "22.72",
			        "CodCollectableAmount": "",
			        "ShippingAmount": "0.00",
			        "ShippingServiceCost": "",
			        "VoucherAmount": "0",
			        "VoucherCode": "",
			        "Status": "shipped",
			        "IsProcessable": "1",
			        "ShipmentProvider": "Toll",
			        "IsDigital": "0",
			        "DigitalDeliveryInfo": "",
			        "TrackingCode": "8475160150695",
			        "TrackingCodePre": "",
			        "Reason": "",
			        "ReasonDetail": "",
			        "PurchaseOrderId": "233634936",
			        "PurchaseOrderNumber": "233634936",
			        "PackageId": "12487290",
			        "PromisedShippingTime": "",
			        "ExtraAttributes": "",
			        "ShippingProviderType": "",
			        "CreatedAt": "2019-03-15 09:16:36",
			        "UpdatedAt": "2019-03-26 13:32:15",
			        "ReturnStatus": ""
			      },
			      {
			        "OrderItemId": "2508855",
			        "ShopId": "29016209",
			        "OrderId": "8412797",
			        "Name": "Levitate 2",
			        "Sku": "190340528026",
			        "Variation": "10",
			        "ShopSku": "BR590SH28PPN-2807524",
			        "ShippingType": "home",
			        "ItemPrice": "249.95",
			        "PaidPrice": "0.00",
			        "Currency": "AUD",
			        "WalletCredits": "249.95",
			        "TaxAmount": "22.72",
			        "CodCollectableAmount": "",
			        "ShippingAmount": "0.00",
			        "ShippingServiceCost": "",
			        "VoucherAmount": "0",
			        "VoucherCode": "",
			        "Status": "shipped",
			        "IsProcessable": "1",
			        "ShipmentProvider": "Toll",
			        "IsDigital": "0",
			        "DigitalDeliveryInfo": "",
			        "TrackingCode": "8475160150695",
			        "TrackingCodePre": "",
			        "Reason": "",
			        "ReasonDetail": "",
			        "PurchaseOrderId": "233634936",
			        "PurchaseOrderNumber": "233634936",
			        "PackageId": "12487290",
			        "PromisedShippingTime": "",
			        "ExtraAttributes": "",
			        "ShippingProviderType": "",
			        "CreatedAt": "2019-03-15 09:16:36",
			        "UpdatedAt": "2019-03-26 13:32:15",
			        "ReturnStatus": ""
			      }
			    ]
			  }
			}
			}
		}';
    }

    public function AccessDeniedJson()
    {
    	return '{
			  "ErrorResponse": {
			    "Head": {
			      "RequestAction": "GetOrders",
			      "ErrorType": "Sender",
			      "ErrorCode": "9",
			      "ErrorMessage": "E009: Access Denied"
			    },
			    "Body": ""
			  }
			}';	
    }


    public function InvalidOrderIdJson()
    {
    	return '{
			  "ErrorResponse": {
			    "Head": {
			      "RequestAction": "GetOrder",
			      "ErrorType": "Sender",
			      "ErrorCode": "16",
			      "ErrorMessage": "E016: \"3538\" Invalid Order ID"
			    },
			    "Body": ""
			  }
			}';	
    }
}