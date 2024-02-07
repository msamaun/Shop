<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label">Product Brand *</label>
                                <select type="text" class="form-control" id="productBrand">
                                    <option value="">Select Brand </option>
                                </select>

                                <label class="form-label">Product Category *</label>
                                <select type="text" class="form-control" id="productCategory">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">Product Description *</label>
                                <input type="text" class="form-control" id="productDescription">


                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="productPrice">


                                <label class="form-label">Product Discount *</label>
                                <input type="text" class="form-control" id="productDiscount">


                                <label class="form-label">Product Discount Price *</label>
                                <input type="text" class="form-control" id="productDiscountPrice">


                                <label class="form-label">Product Stock *</label>
                                <input type="text" class="form-control" id="productStock">

                                <label class="form-label">Product Star *</label>
                                <input type="text" class="form-control" id="productStar">

                                <label class="form-label">Product Remark *</label>
                                <input type="text" class="form-control" id="productRemark">

                                <br/>
                                <img class="w-15" id="newLmg" src="{{asset('admin/images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Product Image *</label>
                                <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImage">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    FillCategoryDropdown();
    FillBrandDropdown();

    async function FillBrandDropdown(){
        let res =await axios.get("/brand-list",HeaderToken())

        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productBrand").append(option);
        })

    }

    async function FillCategoryDropdown(){
        let res =await axios.get("/category-list",HeaderToken())

        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })

    }

    async function Save(){
        let productName = document.getElementById('productName').value;
        let brandName = document.getElementById('productBrand').value;
        let categoryName = document.getElementById('productCategory').value;
        let description = document.getElementById('productDescription').value;
        let price = document.getElementById('productPrice').value;
        let discount = document.getElementById('productDiscount').value;
        let discountPrice = document.getElementById('productDiscountPrice').value;
        let stock = document.getElementById('productStock').value;
        let star = document.getElementById('productStar').value;
        let remark = document.getElementById('productRemark').value;
        let image = document.getElementById('productImage').files[0];

        document.getElementById('modal-close').click();

        let formData = new FormData();
        formData.append('name',productName);
        formData.append('brand_id',brandName);
        formData.append('category_id',categoryName);
        formData.append('description',description);
        formData.append('price',price);
        formData.append('discount',discount);
        formData.append('discount_price',discountPrice);
        formData.append('stock',stock);
        formData.append('star',star);
        formData.append('remark',remark);
        formData.append('image',image);


        const config = {
            headers: {
                'Content-Type': 'multipart/form-data',
                Authorization:getToken()
            }
        };

        showLoader();
        let res = await axios.post("/product-create",formData,config);
        hideLoader();

        if(res.data){
            successToast('Product created successfully');
            document.getElementById('save-form').reset();
            await getList();
        }
        else{
            errorToast("Something went wrong");
        }
    }
</script>
