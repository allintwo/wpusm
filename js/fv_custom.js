
    var myrpfelems = document.getElementsByTagName('video');
   // var nelems = document.querySelectorAll('video source');
    for(var i =0; i< myrpfelems.length; i++)
    {
        var vidlinkowner = myrpfelems[i].getElementsByTagName('source');
        var link = vidlinkowner[0].getAttribute('src');
        if(link.length >0)
        {
            link = link.replace('/','\/');

            var newelem = document.createElement('div');
            newelem.innerHTML = `
                <div id="wpfp_${i}"
         data-item="{&quot;sources&quot;:[{&quot;src&quot;:&quot;${link}&quot;,&quot;type&quot;:&quot;video\/mp4&quot;}],&quot;id&quot;:&quot;1&quot;}"
         class="flowplayer no-brand is-splash no-svg is-paused skin-slim fp-slim fp-edgy"
         style="max-width: 640px; max-height: 360px; " data-ratio="0.5625">
    <div class="fp-ratio" style="padding-top: 56.25%"></div>
            `;
            myrpfelems[i].parentNode.replaceChild(newelem,myrpfelems[i]);
            console.log('done');
        }
    }
