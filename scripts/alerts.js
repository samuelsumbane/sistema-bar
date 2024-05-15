

// backup do banco de dados
const backupFeitoComSucesso = (local)=>{
    swal({
        icon:'success',
        title: 'Backup de banco de dados feito com sucesso.',
        text:`O banco de dados está armazenado no ${local}`
    })
}

const erroAoFazerBackup = ()=>{
    return swal({
        icon:'error',
        title: 'Houve um erro fazer backup',
        text:'Se esse erro persistir contacte o gerente.'
    })
}


const sessionExpired = ()=>{
    swal({
        icon:'warning',
        title: 'Sessão expirada',
        text:`Sua sessão expirou, por favor clique em "OK" para fazer o novo login.`
    }).then(()=>{
        location.reload()
    })
}

const refreshNeeded = ()=>{
    swal({
        icon: 'info',
        title: 'Actualização da pagina necessária',
        text: 'Por favor, actualize a pagina para ter dados actualizados.'
    })
}