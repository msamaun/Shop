<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label">Product Brand *</label>
                                <select type="text" class="form-control" id="productBrandUpdate">
                                    <option value="">Select Brand </option>
                                </select>

                                <label class="form-label">Product Category *</label>
                                <select type="text" class="form-control" id="productCategoryUpdate">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">Product Description *</label>
                                <input type="text" class="form-control" id="productDescriptionUpdate">


                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="productPriceUpdate">


                                <label class="form-label">Product Discount *</label>
                                <input type="text" class="form-control" id="productDiscountUpdate">


                                <label class="form-label">Product Discount Price *</label>
                                <input type="text" class="form-control" id="productDiscountPriceUpdate">


                                <label class="form-label">Product Stock *</label>
                                <input type="text" class="form-control" id="productStockUpdate">

                                <label class="form-label">Product Star *</label>
                                <input type="text" class="form-control" id="productStarUpdate">

                                <label class="form-label">Product Remark *</label>
                                <input type="text" class="form-control" id="productRemarkUpdate">

                                <br/>
                                <img class="w-15" id="newLmg" src="{{asset('admin/images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Product Image *</label>
                                <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImageUpdate">

                                <input type="text" class="d-none" id="updateID">
                                <input type="text" class="d-none" id="oldImage">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn bg-gradient-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    UpdateFillBrandForm();
    UpdateFillCategoryForm();
    async function UpdateFillBrandForm(){
        let res =await axios.get("/brand-list",HeaderToken())
        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productBrandUpdate").append(option);
        })
    }
    async function UpdateFillCategoryForm(){
        let res =await axios.get("/category-list",HeaderToken())
        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }

    async function FillUpUpdateForm(id,filePath){
        document.getElementById("updateID").value = id;
        document.getElementById("oldImage").value = filePath;

        showLoader();
        await UpdateFillBrandForm();
        await UpdateFillCategoryForm();
        const res = await axios.post("/product-by-id",{id:id},HeaderToken())
        hideLoader();

        document.getElementById("productNameUpdate").value = res.data['data']['name'];
        document.getElementById("productBrandUpdate").value = res.data['data']['brand_id'];
        document.getElementById("productCategoryUpdate").value = res.data['data']['category_id'];
        document.getElementById("productDescriptionUpdate").value = res.data['data']['description'];
        document.getElementById("productPriceUpdate").value = res.data['data']['price'];
        document.getElementById("productDiscountUpdate").value = res.data['data']['discount'];
        document.getElementById("productDiscountPriceUpdate").value = res.data['data']['discount_price'];
        document.getElementById("productStockUpdate").value = res.data['data']['stock'];
        document.getElementById("productStarUpdate").value = res.data['data']['star'];
        document.getElementById("productRemarkUpdate").value = res.data['data']['remark'];

    }

    async function Update(){
        let productName = document.getElementById('productNameUpdate').value;
        let brandName = document.getElementById('productBrandUpdate').value;
        let categoryName = document.getElementById('productCategoryUpdate').value;
        let description = document.getElementById('productDescriptionUpdate').value;
        let price = document.getElementById('productPriceUpdate').value;
        let discount = document.getElementById('productDiscountUpdate').value;
        let discountPrice = document.getElementById('productDiscountPriceUpdate').value;
        let stock = document.getElementById('productStockUpdate').value;
        let star = document.getElementById('productStarUpdate').value;
        let remark = document.getElementById('productRemarkUpdate').value;
        let image = document.getElementById('productImageUpdate').files[0];

        let oldLmg=document.getElementById('updateID').value
        let oldImage=document.getElementById('oldImage').value


        document.getElementById('update-modal-close').click();

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

        formData.append('id',oldLmg)
        formData.append('file_path',oldImage)

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }

        showLoader();
        let res = await axios.post("/product-update",formData,config);
        hideLoader();
        if (res.status === 200) {
            successToast("Product Update Successfully");
            document.getElementById('update-form').reset();
            await getList();
        }
        else {
            errorToast("Failed To Update Product");
        }
    }
</script>
