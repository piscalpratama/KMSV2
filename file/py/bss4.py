import requests
from bs4 import BeautifulSoup

def get_text(url: str) -> tuple:
    site = requests.get(url)
    soup = BeautifulSoup(site.text, 'html.parser')
    
    for script in soup(["script", "style"]):
        script.extract()
        
    text = soup.get_text()
    lines = (line.strip() for line in text.splitlines())
    
    chunks = (phrase.strip() for line in lines for phrase in line.split("  "))
    
    text = '\n'.join(chunk for chunk in chunks if chunk)

    return text