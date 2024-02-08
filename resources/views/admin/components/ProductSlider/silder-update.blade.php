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
                                <label class="form-label">ProductSlider Name *</label>
                                <input type="text" class="form-control" id="ProductSliderNameUpdate">

                                <label class="form-label">Product Name *</label>
                                <select type="text" class="form-control" id="productNameUpdate">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">ProductSlider Description *</label>
                                <input type="text" class="form-control" id="ProductSliderDescriptionUpdate">

                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="ProductSliderPrice">

                                <br/>
                                <img class="w-15" id="oldLmg" src="{{asset('images/default.jpg')}}">
                                <br/>

                                <label class="form-label">ProductSlider Image *</label>
                                <input oninput="oldLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="ProductSliderImageUpdate">

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

    FillProductDropdown()
    async function FillProductDropdown(){
        let res =await axios.get("/product-list",HeaderToken())

        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productNameUpdate").append(option);
        })


    }

    async function FillUpUpdateForm(id, filePath) {
        document.getElementById("updateID").value = id;
        document.getElementById("oldImage").value = filePath;
        document.getElementById("oldLmg").src = filePath;

        showLoader();
        let res = await axios.post("/product-slider-by-id",{id:id},HeaderToken());
        hideLoader();

        document.getElementById("ProductSliderNameUpdate").value = res.data['data']['title'];
        document.getElementById("ProductSliderDescriptionUpdate").value = res.data['data']['short_description'];
        document.getElementById("ProductSliderPrice").value = res.data['data']['price'];
        document.getElementById("productNameUpdate").value = res.data['data']['name'];


    }

    async function Update() {
        let categoryName = document.getElementById('ProductSliderNameUpdate').value;
        let categoryDescription = document.getElementById('ProductSliderDescriptionUpdate').value;
        let productName = document.getElementById('productNameUpdate').value;
        let productPrice = document.getElementById('ProductSliderPrice').value;
        let categoryImage = document.getElementById('ProductSliderImageUpdate').files[0];
        let oldLmg = document.getElementById('updateID').value
        let oldImage = document.getElementById('oldImage').value

        document.getElementById('update-modal-close').click();

        let formData = new FormData();
        formData.append('title',categoryName);
        formData.append('short_description',categoryDescription);
        formData.append('price',productPrice);
        formData.append('product_id',productName);
        formData.append('image',categoryImage);
        formData.append('id',oldLmg)
        formData.append('file_path',oldImage)


        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }

        showLoader();
        let res = await axios.post("/product-slider-update",formData,config);
        hideLoader();
        if(res.status === 200){
            successToast("Category Updated Successfully");
            document.getElementById('update-form').reset();
            await getList();
        }else{
            errorToast("Something went wrong");
        }

    }
</script>

