// Initialize Nette Forms on page load
import netteForms from 'nette-forms'
import naja from 'naja'

netteForms.initOnLoad()

naja.uiHandler.selector = '[data-naja]'
naja.initialize()
