import { Application, Controller } from 'https://cdn.jsdelivr.net/npm/@hotwired/stimulus@3.2.2/+esm'

const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

export { LibStimulus, Controller }
