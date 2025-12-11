// public/js/video.js
(async () => {
  const form = document.getElementById('joinForm');
  const localMedia = document.getElementById('localMedia');
  const remoteMedia = document.getElementById('remoteMedia');
  let roomInstance = null;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const identity = document.getElementById('identity').value;
    const room = document.getElementById('room').value;

    // Pede token ao backend
    const resp = await fetch(`/video/token?identity=${encodeURIComponent(identity)}&room=${encodeURIComponent(room)}`);
    const data = await resp.json();
    const token = data.token;

    try {
      roomInstance = await Twilio.Video.connect(token, {
        name: room,
        audio: true,
        video: { width: 640 }
      });

      // local tracks
      const localParticipant = roomInstance.localParticipant;
      localParticipant.tracks.forEach(publication => {
        const track = publication.track;
        if (track && track.attach) localMedia.appendChild(track.attach());
      });

      // remote participants already in room
      roomInstance.participants.forEach(participant => {
        attachParticipantTracks(participant, remoteMedia);
      });

      // new participant connected
      roomInstance.on('participantConnected', participant => {
        attachParticipantTracks(participant, remoteMedia);
      });

      roomInstance.on('participantDisconnected', participant => {
        detachParticipantTracks(participant);
      });

      window.addEventListener('beforeunload', () => {
        if (roomInstance) roomInstance.disconnect();
      });

    } catch (err) {
      console.error('Erro ao conectar:', err);
      alert('Não foi possível conectar: ' + err.message);
    }
  });

  function attachParticipantTracks(participant, container) {
    participant.tracks.forEach(publication => {
      if (publication.isSubscribed) {
        const track = publication.track;
        container.appendChild(track.attach());
      }
    });

    participant.on('trackSubscribed', track => {
      container.appendChild(track.attach());
    });

    participant.on('trackUnsubscribed', track => {
      track.detach().forEach(el => el.remove());
    });
  }

  function detachParticipantTracks(participant) {
    participant.tracks.forEach(publication => {
      if (publication.track) {
        publication.track.detach().forEach(el => el.remove());
      }
    });
  }
})();