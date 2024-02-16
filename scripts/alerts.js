

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


