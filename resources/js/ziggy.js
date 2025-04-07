const Ziggy = {"url":"http:\/\/127.0.0.1:8000","port":8000,"defaults":{},"routes":{"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"profile.edit":{"uri":"profile","methods":["GET","HEAD"]},"profile.update":{"uri":"profile","methods":["PATCH"]},"profile.destroy":{"uri":"profile","methods":["DELETE"]},"tasks.index":{"uri":"tasks","methods":["GET","HEAD"]},"tasks.create":{"uri":"tasks\/create","methods":["GET","HEAD"]},"tasks.store":{"uri":"tasks","methods":["POST"]},"tasks.show":{"uri":"tasks\/{task}","methods":["GET","HEAD"],"parameters":["task"],"bindings":{"task":"id"}},"tasks.edit":{"uri":"tasks\/{task}\/edit","methods":["GET","HEAD"],"parameters":["task"],"bindings":{"task":"id"}},"tasks.update":{"uri":"tasks\/{task}","methods":["PUT","PATCH"],"parameters":["task"],"bindings":{"task":"id"}},"tasks.destroy":{"uri":"tasks\/{task}","methods":["DELETE"],"parameters":["task"],"bindings":{"task":"id"}},"register":{"uri":"register","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.store":{"uri":"reset-password","methods":["POST"]},"verification.notice":{"uri":"verify-email","methods":["GET","HEAD"]},"verification.verify":{"uri":"verify-email\/{id}\/{hash}","methods":["GET","HEAD"],"parameters":["id","hash"]},"verification.send":{"uri":"email\/verification-notification","methods":["POST"]},"password.confirm":{"uri":"confirm-password","methods":["GET","HEAD"]},"password.update":{"uri":"password","methods":["PUT"]},"logout":{"uri":"logout","methods":["POST"]},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
