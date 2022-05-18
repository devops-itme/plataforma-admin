export const listener = (item, action, event = 'change') =>{
    item.addEventListener(event, async () => {
        action();
    });
}