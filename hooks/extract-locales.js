// region import
const fs = require('fs')
const path = require('path')
const po2json = require('po2json')
// endregion

// region helpers
const isDirectory = source => fs.lstatSync(source).isDirectory()
const getDirectories = source =>
	fs
		.readdirSync(source)
		.map(name => path.join(source, name))
		.filter(isDirectory)
		.map(path => path.split('/').pop())
// endregion

// region setup
const [BRANCH_NAME] = process.argv.slice(2)
const PROJECT = 'embeds-wordpress'
// endregion

// region run
const locales = getDirectories(`po/${PROJECT}-po-archive/locales`)
let prodError = false

locales.forEach(locale => {
	const parsed = po2json.parse(
		fs.readFileSync(`po/${PROJECT}-po-archive/locales/${locale}/LC_MESSAGES/${PROJECT}.po`)
	)

	const translations = Object.keys(parsed)
		.filter(Boolean)
		.reduce((acc, val) => ((acc[val] = parsed[val].filter(Boolean).pop()), acc), {})

	// ignore assets with no translations
	const isEmpty = Object.keys(translations).every(key => translations[key] === undefined)
	if (isEmpty) return

	// validate
	Object.keys(translations).forEach(key => {
		if (!translations[key]) {
			prodError = true
			console.warn(`Missing translation: ${JSON.stringify({ locale, key })}`)
		}
	})

	// copy
	fs.copyFileSync(
		`po/${PROJECT}-po-archive/locales/${locale}/LC_MESSAGES/${PROJECT}.po`,
		`attach-embeds/languages/attach-embeds-${locale}.po`
	)
})

if (prodError && BRANCH_NAME.startsWith('prod')) process.exit(1)
// endregion
