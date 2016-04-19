# CHANGELOG

## 1.0.0 - 2016-04-19

- First stable release of QuickPay PHP Client for QuickPay api v10.
- This release follows PSR2 standards and is not comptible with the previous version.
- All methods are now in **camelCase** format (PSR1.Methods.CamelCapsMethodName.NotCamelCaps).
- In QuickPay\API\Response `as_raw` changed to `asRaw`, `as_object` changed to `asObject`, `as_array` changed to `asArray`, `http_status` changed to `httpStatus` and finally `is_success` changed to `isSuccess`.
- Also QuickPay\QuickPay does not `require_once` for needed files anymore, so the file does **not have any side effects** (PSR1.Files.SideEffects.FoundWithSymbols).
- You should use an autoloader, e.g. by utilizing `composer` for the files to be included correctly or simply `require_once` yourself.
- See the [full list of changes](https://github.com/QuickPay/quickpay-php-client/commit/d59ca916843a4bd72b29b2b5fc1bfe918bfbc637)

## 0.1.0 - 2016-04-14

- First versioned release of QuickPay PHP Client for QuickPay api v10.
- This release does not break backward compability with previous development versions of the client.
