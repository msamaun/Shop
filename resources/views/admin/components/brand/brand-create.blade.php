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
                                <label class="form-label">Brand Name *</label>
                                <input type="text" class="form-control" id="brandName">

                                <label class="form-label">Brand Description *</label>
                                <input type="text" class="form-control" id="brandDescription">

                                <br/>
                                <img class="w-15" id="newLmg" src="{{asset('admin/images/default.jpg')}}">
                                <br/>

                                <label class="form-label">Brand Image *</label>
                                <input oninput="newLmg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="brandImage">

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
    async function Save(){
        let brandName = document.getElementById('brandName').value
        let brandDescription = document.getElementById('brandDescription').value
        let brandImage = document.getElementById('brandImage').files[0]

        document.getElementById('modal-close').click();

        let formData = new FormData();
        formData.append('name', brandName);
        formData.append('description', brandDescription);
        formData.append('image', brandImage);

        const config = {
            headers: {
                'content-type': 'multipart/form-data',
                Authorization:getToken()
            }
        }
        showLoader()
        let res = await axios.post("/brand-create",formData,config);
        hideLoader()

        if(res.status===200){
            successToast("Brand created successfully");
            document.getElementById('save-form').reset();
            await getList();
        }
        else{
            errorToast(res.data.message);
        }
    }
</script>
