import SignaturePad from 'https://cdn.jsdelivr.net/npm/signature_pad@5.0.4/+esm';

const makeSigBlock = () => {
    let container = document.createElement('div');
    container.className = 'd-flex flex-column align-items-start gap-2 p-3 border-top noprint';
    let sigBlock = document.createElement('canvas');
    sigBlock.style.border = '1px #777 dotted';
    sigBlock.id = 'sigblock';
    sigBlock.style.width = '375px';
    sigBlock.style.height = '150px';
    sigBlock.width = 375;
    sigBlock.height = 150;
    let btnBlock = document.createElement('div');
    btnBlock.className = 'd-flex gap-2';
    let clearBtn = document.createElement('button');
    clearBtn.className = 'btn btn-sm btn-secondary';
    clearBtn.innerHTML = '<i class="bi bi-eraser"></i> Clear';
    clearBtn.addEventListener('click', () => {
        document.dispatchEvent(new CustomEvent('signature.clear'));
    });
    let undoBtn = document.createElement('button');
    undoBtn.className = 'btn btn-sm btn-secondary';
    undoBtn.innerHTML = '<i class="bi bi-arrow-counterclockwise"></i> Undo';
    undoBtn.addEventListener('click', () => {
        document.dispatchEvent(new CustomEvent('signature.undo'));
    });
    let saveBtn = document.createElement('button');
    saveBtn.className = 'btn btn-sm btn-primary';
    saveBtn.innerHTML = '<i class="bi bi-save"></i> Save';
    saveBtn.addEventListener('click', () => {
        document.dispatchEvent(new CustomEvent('signature.save'));
    });
    btnBlock.appendChild(clearBtn);
    btnBlock.appendChild(undoBtn);
    btnBlock.appendChild(saveBtn);
    container.appendChild(sigBlock);
    container.appendChild(btnBlock);
    return container;
};

const makeManualSigBlock = () => {
    let container = document.createElement('div');
    container.className = 'd-none gap-2 only-print';
    let sigBlock = document.createElement('div');
    sigBlock.style.height = '150px';
    sigBlock.style.width = '79%';
    sigBlock.appendChild(document.createElement('hr'));
    sigBlock.appendChild(document.createTextNode('Signature'));
    let dateBlock = document.createElement('div');
    dateBlock.style.height = '150px';
    dateBlock.style.width = '19%';
    dateBlock.appendChild(document.createElement('hr'));
    dateBlock.appendChild(document.createTextNode('Date'));
    container.appendChild(sigBlock);
    container.appendChild(dateBlock);
    return container;
}

const sigBlock = makeSigBlock();
document.querySelector('main').appendChild(sigBlock);

const manualSigBlock = makeManualSigBlock();
document.querySelector('main').appendChild(manualSigBlock);

const signhere = new SignaturePad(sigBlock.querySelector('canvas'), {
    backgroundColor: 'rgba(0, 0, 0, 0.05)',
    penColor: 'black'
});

document.addEventListener('signature.clear', () => { signhere.clear(); });
document.addEventListener('signature.undo', () => {
    var data = signhere.toData();
    if (data) {
        data.pop();
        signhere.fromData(data);
    }
});

const saveSignature = (sigdata) => {
    fetch('sign/<?= $identifier ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ signature: sigdata })
    })
    .then(response => response.json())
    .then(data => {
        if (data.saved) {
            alert('Thanks! Your signature has been saved.');
            window.location.replace(window.location.href);
        }
        else {
            alert('There was an error saving your signature. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error saving your signature. Please try again.');
    });
};

const checkSignatureExists = (sigdata) => {
    fetch('sigcheck/<?= $identifier ?>', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            alert('This document hs already been signed.');
        }
        else {
            saveSignature(sigdata);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error while trying to check for an existing signature. Please try again.');
    });
};

document.addEventListener('signature.save', () => {
    let DataURL = signhere.toDataURL("image/svg+xml");
    if (!DataURL) {
        alert('Hmm, it seems you haven\'t signed yet, or your signature appears blank? Please check your signature and try again.');
        return;
    }
    if (confirm('Are you ready to sign this document? Click or tap "OK" to proceed.')) {
        checkSignatureExists(DataURL);
    }
});