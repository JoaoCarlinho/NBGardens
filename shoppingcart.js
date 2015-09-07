            function AddPriceObject(itemToPrice){
                var TheCartItemPrice = document.getElementById('cartItemPrice');
                var TheCartItem = document.getElementById("CartItem" + itemToPrice);
                var ThePriceDiv = document.createElement('div');
                var ThePrice = document.createTextNode("$" + TheCartItem.getAttribute("data-price"));
                ThePriceDiv.id = 'PriceItem' + itemToPrice;
                ThePriceDiv.appendChild(ThePrice);
                TheCartItemPrice.appendChild(ThePriceDiv);
            }
                
            function AddQuantityObject(item){
                var TheCartItemQuantity = document.getElementById('cartItemQuantity');
                var TheQuantityDiv = document.createElement('div');
                var TheQuantity = document.createTextNode(1);
                TheQuantityDiv.id = 'QuantityItem' + item;
                TheQuantityDiv.appendChild(TheQuantity);
                TheCartItemQuantity.appendChild(TheQuantityDiv);
            }
            
/*****Function for incrementing the number of certain product if product added to cart more than once******/            
            //function IncrementQuantityObject(item){
            //    var TheCartItemQuantity = document.getElementById('cartItemQuantity');
            //    var TheQuantityDiv = document.createElement('div');
  /**************Read the value previously sotred in TheQuantityDiv************************************/            
            //    var PreviousQuantity = 
/****************ParseInt the previous quanityt and assign this value to the TheQuantity Div*********************/     
            //    var TheQuantity = document.createTextNode("1");
            //    TheQuantityDiv.id = 'QuantityItem' + item;
            //    TheQuantityDiv.appendChild(TheQuantity);
            //    TheCartItemQuantity.appendChild(TheQuantityDiv);
        //    }
            

            
            function AddTotalObject(itemToRemove){
                
            }
            
            function RemoveCartItem(item){
                var obj = document.getElementById('CartItem' + item);
                obj.parentNode.removeChild(obj);
                obj = document.getElementById('RemoveItem' + item);
                obj.parentNode.removeChild(obj);
                obj = document.getElementById('PriceItem' + item );
                obj.parentNode.removeChild(obj);
                obj = document.getElementById('QuantityItem' + item );
                obj.parentNode.removeChild(obj);
            }
            
            function AddRemoveObject(itemToRemove){
                var TheCartItemRemove = document.getElementById('cartItemRemove');
                var TheRemoveDiv = document.createElement('div');
                var TheRemoveImage = document.createElement('img');
                TheRemoveDiv.id = 'RemoveItem'+itemToRemove;
                TheRemoveImage.src = "images/remove.png";
                TheRemoveImage.height = 25;
                TheRemoveImage.onclick = function(){RemoveCartItem(itemToRemove);};
                TheRemoveDiv.appendChild(TheRemoveImage);
                TheCartItemRemove.appendChild(TheRemoveDiv);
            }
            
            function ShowCartItems(){
                var TheCartItems = document.getElementById('cartItemImages');
                var TheCartItemRemove = document.getElementById('cartItemRemove');
                var TheCartItemPrice = document.getElementById('cartItemPrice')
                var TheCartItemQuantity = document.getElementById('cartItemQuantity')
                var TheRemoveNodeList = TheCartItemRemove.getElementsByTagName('div');
                var TheImageNodeList = TheCartItems.getElementsByTagName('div');
                var ThePriceNodeList = TheCartItemPrice.getElementsByTagName('div');
                var TheQuantityNodeList = TheCartItemQuantity.getElementsByTagName('div');
                for(i = 0; i<TheImageNodeList.length;i++){
                    TheImageNodeList[i].style.position = "absolute";
                    TheImageNodeList[i].style.top = (120 * i) + "px";
                    TheImageNodeList[i].style.left =(0) + "px";
                    TheRemoveNodeList[i].style.position = "absolute";
                    TheRemoveNodeList[i].style.top = (120 * i) + 50 +"px";
                    TheRemoveNodeList[i].style.left = (0)+"px";
                    ThePriceNodeList[i].style.position = "absolute";
                    ThePriceNodeList[i].style.top = (120 * i) + 50 + "px";
                    ThePriceNodeList[i].style.left = (0) + "px";
                    TheQuantityNodeList[i].style.position = "absolute";
                    TheQuantityNodeList[i].style.top = (120 * i) + 50 + "px";
                    TheQuantityNodeList[i].style.left = (0) + "px";
                }
            }
            
            function FindIfIdExists(obj, id){
                var TheNodeList = obj.getElementsByTagName('div');
                for(NodeNumber = 0; NodeNumber<TheNodeList.length;NodeNumber++){
                    if(TheNodeList[NodeNumber].id === id){
                        return NodeNumber + 1;
                    }
                }
                return 0;
            }
            
            function ContinueShopping(){
                    document.getElementById('products').style.visibility = 'visible';
                    document.getElementById('TheCart').style.visibility = 'hidden';
                    
            }
            
            function AddToCart(itemToAdd){
                var TheCartItemImages = document.getElementById('cartItemImages');
                var FoundNodeCount = FindIfIdExists(TheCartItemImages,"CartItem"+itemToAdd);
                if(FoundNodeCount === 0){
                    var TheCartItemToAdd = document.getElementById(itemToAdd).cloneNode(true);
                    TheCartItemToAdd.id = "CartItem"+itemToAdd;
                    TheCartItemToAdd.childNodes[1].height=100;
                    TheCartItemImages.appendChild(TheCartItemToAdd);
                    AddRemoveObject(itemToAdd);
                    AddPriceObject(itemToAdd);
                    AddQuantityObject(itemToAdd);
                    AddTotalObject(itemToAdd);
                }
               
    /* Here, Total Objects will be incremented if there already exists a div with same id(CartItem + itemToAdd
    in TheCartItemImages*/           
               // else{
                //IncrementQuantityObject(itemToAdd)
                //IncrementPriceObject(itemToAdd)
                //}
                ShowCartItems();
                document.getElementById('products').style.visibility='hidden';
                document.getElementById('TheCart').style.visibility='visible';
            }