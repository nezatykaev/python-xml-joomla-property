from xmltodict import parse
from requests import post

with open('Commercial.xml', 'r', encoding='utf-8') as file:
    for offer in parse(file.read())['realty-feed']['offer']:
        offer['id'] = offer.pop('@internal-id')
        for i, image in enumerate(offer['image']):
            if isinstance(image, dict):
                offer['image'][i] = image['#text']

        print(post('https://domain.ru/api.php', json=offer))
