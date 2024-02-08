<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create ProductSlider</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">ProductSlider Title *</label>
                                <input type="text" class="form-control" id="ProductSliderTitle">

                                <label class="form-label">Product Name *</label>
                                <select type="text" class="form-control" id="ProductSliderName">
                                    <option value="">Select Category </option>
                                </select>

                                <label class="form-label">ProductSlider Description *</label>
                                <input type="text" class="form-control" id="ProductSliderDescription">

                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="ProductSliderPrice">

                                <br/>
                                <img class="w-15" id="newLmg" src="{{asset('admin/images/default.jpg')}}">
                                <br/>

                                <label class="form-label">ProductSlider Image *</label>
                                <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="ProductSliderImage">

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
    FillProductDropdown()
    async function FillProductDropdown(){
        let res =await axios.get("/product-list",HeaderToken())

        res.data['data'].forEach((item)=>{
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#ProductSliderName").append(option);
        })


    }


    async function Save(){
        let ProductSliderTitle = document.getElementById('ProductSliderTitle').value
        let ProductSliderName = document.getElementById('ProductSliderName').value
        let ProductSliderDescription = document.getElementById('ProductSliderDescription').value
        let ProductSliderPrice = document.getElementById('ProductSliderPrice').value
        let ProductSliderImage = document.getElementById('ProductSliderImage').files[0]

        document.getElementById('modal-close').click();

        let formData = new FormData();
        formData.append('title',ProductSliderTitle);
        formData.append('product_id',ProductSliderName);
        formData.append('price',ProductSliderPrice);
        formData.append('short_description', ProductSliderDescription);
        formData.append('image', ProductSliderImage);


        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }
        showLoader()
        let res = await axios.post("/product-slider-create",formData,config);
        hideLoader()

        if(res.status===200){
            successToast("Product Slider created successfully");
            document.getElementById('save-form').reset();
            await getList();
        }
        else{
            errorToast(res.data.message);
        }
    }
</script>

