const changeRoom = async (room) => {
    try {
        const response = await fetch(`/sessionmods/setroom/${room}`, {method: 'POST'});
        const data = await response.text();
        return room === data.trim();
    } catch (error) {
        throw new Error(`Failed to change room: ${error.message}`);
    }
}

const changeRoomIndicator = (room) => {
    if (room) {
        const roomIndicator = document.querySelector('[data-room-indicator]');
        if (roomIndicator) {
            roomIndicator.textContent = ` ${room.charAt(0).toUpperCase() + room.slice(1)} Room`;
            roomIndicator.className = `text-${room}`;
        }
    }
}

document.addEventListener('room.change', (event) => {
    changeRoom(event.detail)
    .then(() => {
        document.dispatchEvent(new CustomEvent('room.changed', { detail: event.detail }));
    })
    .catch(() => {
        alert('Failed to change room. Please try again.');
    });
});

document.addEventListener('room.changed', event => {
    changeRoomIndicator(event.detail);
});

document.addEventListener('room.exited', () =>{window.location.reload();});

document.addEventListener('room.exit', event => {
    fetch('/sessionmods/exitroom', {method: 'POST'})
    .then(() => {
        document.dispatchEvent(new CustomEvent('room.exited', { detail: event.detail }));
    })
    .catch(() => {
        alert('Failed to exit room. Please try again.');
    });
});

document.addEventListener('DOMContentLoaded', async event => {
    try {
        const response = await fetch('/sessionmods/getroom', {method: 'POST'});
        const data = await response.text();
        changeRoomIndicator(data.trim());
    } catch (error) {
        console.error('Error fetching room:', error);
    }
});