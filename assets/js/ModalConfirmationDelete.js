let removeId = null;

function askDelete(id){
    document.body.classList.add('overflow-hidden');
    modal.classList.add('fixed')
    modal.classList.remove('hidden')
    removeId = id;
}

function deleteConfirm(){
    if(removeId == null){
        document.body.classList.remove('overflow-hidden');
        let modal = document.getElementById('modal');
        modal.classList.add('hidden')
        modal.classList.remove('fixed')
        return;
    }
    
    window.location.href = '/animal/delete/' + removeId;
    removeId = null;
}

function cancelRemove(){
    removeId = null;
    document.body.classList.remove('overflow-hidden');
    let modal = document.getElementById('modal');
    modal.classList.add('hidden')
    modal.classList.remove('fixed')
}

