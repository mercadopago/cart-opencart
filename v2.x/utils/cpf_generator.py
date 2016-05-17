def cpf_funcional():
                                                                                                    
    n = [random.randrange(10) for i in xrange(9)]
                                                                                                    
    # calcula digito 1 e acrescenta ao numero
    s = sum(x * y for x, y in zip(n, range(10, 1, -1)))
    d1 = 11 - s % 11
    if d1 >= 10:
        d1 = 0
    n.append(d1)
                                                                                                    
    # calcula digito 2 e acrescenta ao numero
    s = sum(x * y for x, y in zip(n, range(11, 1, -1)))
    d2 = 11 - s % 11
    if d2 >= 10:
        d2 = 0
    n.append(d2)
                                                                                                    
    return "%d%d%d.%d%d%d.%d%d%d-%d%d" % tuple(n)